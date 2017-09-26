<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\MetaData;
use App\Models\AlbumImg;
use App\Models\Tag;
use App\Models\TagObjects;

use Helper, File, Session, Auth;

class AlbumController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {       
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Album::where('album.status', 1);
              
        if( $name != ''){
            $query->where('album.name_vi', 'LIKE', '%'.$name.'%');            
        }
        
        $query->leftJoin('album_img', 'album_img.id', '=','album.thumbnail_id');        
        
        $query->orderBy('album.id', 'desc');
        
        $items = $query->select(['album_img.image_url','album.*', 'album.id as album_id' ])->paginate(50);   

        return view('backend.album.index', compact( 'items', 'arrSearch'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        $tagViList = Tag::where('type', 1)->orderBy('id', 'desc')->get();
        $tagEnList = Tag::where('type', 2)->orderBy('id', 'desc')->get();
        return view('backend.album.create', compact('tagEnList', 'tagViList'));
    }  

    
    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[
            'name_vi' => 'required',
            'slug_vi' => 'required',
            //'name_en' => 'required',
            //'slug_en' => 'required'
        ],
        [
            'name_vi.required' => 'Bạn chưa nhập tên bộ sưu tập VI',
            'slug_vi.required' => 'Bạn chưa nhập slug VI',
            //'name_en.required' => 'Bạn chưa nhập tên bộ sưu tập EN',
            //'slug_en.required' => 'Bạn chưa nhập slug EN',
        ]);        
        
        $dataArr['alias_vi'] = Helper::stripUnicode($dataArr['name_vi']);        
                   
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        $rs = Album::create($dataArr);
        $id = $rs->id;

        // xu ly tags
        if( !empty( $dataArr['tags_vi'] ) && $id ){           

            foreach ($dataArr['tags_vi'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $id;
                $model->tag_id  = $tag_id;
                $model->object_type  = 2;
                $model->type = 1;
                $model->save();
            }
        }
        if( !empty( $dataArr['tags_en'] ) && $id ){           

            foreach ($dataArr['tags_en'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $id;
                $model->tag_id  = $tag_id;
                $model->object_type  = 2;
                $model->type = 2;
                $model->save();
            }
        }

        $this->storeMeta( $id, 0, $dataArr);
        $this->storeImage( $id, $dataArr);

        Session::flash('message', 'Tạo mới bộ sưu tập thành công');


        return redirect()->route('album.index');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $detail = Album::find($id);

        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }
        $hinhArr = (object) [];       

        $hinhArr = AlbumImg::where('album_id', $id)->lists('image_url', 'id');   
        
        $tagViList = Tag::where('type', 1)->orderBy('id', 'desc')->get();
        $tagEnList = Tag::where('type', 2)->orderBy('id', 'desc')->get();
        
        $tmpArr = TagObjects::where(['object_id' => $id, 'object_type' => 2])->get();
        $tagSelectedVi = $tagSelectedEn = [];
        if( $tmpArr->count() > 0 ){
            foreach ($tmpArr as $value) {
                if($value->type == 1){
                    $tagSelectedVi[] = $value->tag_id;
                }else{
                    $tagSelectedEn[] = $value->tag_id;
                }
            }
        }

        return view('backend.album.edit', compact( 'detail', 'meta', 'hinhArr', 'tagViList', 'tagEnList', 'tagSelectedVi', 'tagSelectedEn'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[
            'name_vi' => 'required',
            'slug_vi' => 'required',
            //'name_en' => 'required',
            //'slug_en' => 'required'
        ],
        [
            'name_vi.required' => 'Bạn chưa nhập tên bộ sưu tập VI',
            'slug_vi.required' => 'Bạn chưa nhập slug VI',
           // 'name_en.required' => 'Bạn chưa nhập tên bộ sưu tập EN',
           // 'slug_en.required' => 'Bạn chưa nhập slug EN',
        ]);        
        
        $dataArr['alias_vi'] = Helper::stripUnicode($dataArr['name_vi']);        
        $dataArr['is_menu'] = isset($dataArr['is_menu']) ? 1 : 0;        
        $dataArr['updated_user'] = Auth::user()->id; 

        $model = Album::find($dataArr['id']);
        $model->update($dataArr);

        // xu ly tags
        TagObjects::where(['object_id' => $dataArr['id'], 'object_type' => 2])->delete();
        if( !empty( $dataArr['tags_vi'] ) && $dataArr['id'] ){           

            foreach ($dataArr['tags_vi'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $dataArr['id'];
                $model->tag_id  = $tag_id;
                $model->type = 1;
                $model->object_type  = 2;
                $model->save();
            }
        }
        if( !empty( $dataArr['tags_en'] ) && $dataArr['id'] ){           

            foreach ($dataArr['tags_en'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $dataArr['id'];
                $model->tag_id  = $tag_id;
                $model->object_type  = 2;
                $model->type = 2;
                $model->save();
            }
        }

        $this->storeImage( $dataArr['id'], $dataArr);
        $this->storeMeta($dataArr['id'], $dataArr['meta_id'], $dataArr);
        Session::flash('message', 'Cập nhật bộ sưu tập thành công');

        return redirect()->route('album.edit', $dataArr['id']);
    }
    public function storeImage($id, $dataArr){        
        //process old image
        $imageIdArr = isset($dataArr['image_id']) ? $dataArr['image_id'] : [];
        $hinhXoaArr = AlbumImg::where('album_id', $id)->whereNotIn('id', $imageIdArr)->lists('id');
        if( $hinhXoaArr )
        {
            foreach ($hinhXoaArr as $image_id_xoa) {
                $model = AlbumImg::find($image_id_xoa);
                $urlXoa = config('decoos.upload_path')."/".$model->image_url;
                if(is_file($urlXoa)){
                    unlink($urlXoa);
                }
                $model->delete();
            }
        }       

        //process new image
        if( isset( $dataArr['thumbnail_id'])){
            $thumbnail_id = $dataArr['thumbnail_id'];

            $imageArr = []; 

            if( !empty( $dataArr['image_tmp_url'] )){

                foreach ($dataArr['image_tmp_url'] as $k => $image_url) {

                    if( $image_url && $dataArr['image_tmp_name'][$k] ){

                        $tmp = explode('/', $image_url);

                        if(!is_dir('public/uploads/'.date('Y/m/d'))){
                            mkdir('public/uploads/'.date('Y/m/d'), 0777, true);
                        }

                        $destionation = date('Y/m/d'). '/'. end($tmp);
                        
                        File::move(config('decoos.upload_path').$image_url, config('decoos.upload_path').$destionation);

                        $imageArr['name'][] = $destionation;

                        $imageArr['is_thumbnail'][] = $dataArr['thumbnail_id'] == $image_url  ? 1 : 0;
                    }
                }
            }
            if( !empty($imageArr['name']) ){
                foreach ($imageArr['name'] as $key => $name) {
                    $rs = AlbumImg::create(['album_id' => $id, 'image_url' => $name, 'display_order' => 1]);                
                    $image_id = $rs->id;
                    if( $imageArr['is_thumbnail'][$key] == 1){
                        $thumbnail_id = $image_id;
                    }
                }
            }
            $model = Album::find( $id );
            $model->thumbnail_id = $thumbnail_id;
            $model->save();
        }
    }
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = [
            'title_vi' => $dataArr['meta_title_vi'], 
            'description_vi' => $dataArr['meta_description_vi'], 
            'keywords_vi'=> $dataArr['meta_keywords_vi'], 
            'custom_text_vi' => $dataArr['custom_text_vi'], 
            //'title_en' => $dataArr['meta_title_en'], 
            //'description_en' => $dataArr['meta_description_en'], 
            //'keywords_en'=> $dataArr['meta_keywords_en'], 
            //'custom_text_en' => $dataArr['custom_text_en'], 
            'updated_user' => Auth::user()->id
        ];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            
            $modelSp = Album::find( $id );
            $modelSp->meta_id = $meta_id;
            $modelSp->save();
        }else {
            $model = MetaData::find($meta_id);           
            $model->update( $arrData );
        }              
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // delete
        $model = Album::find($id);
        $model->delete();
        AlbumImg::where('album_id', $id)->delete();

        // redirect
        Session::flash('message', 'Xóa bộ sưu tập thành công');
        return redirect()->route('album.index');
    }   
}
