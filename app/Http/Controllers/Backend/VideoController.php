<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\MetaData;
use App\Models\Tag;
use App\Models\TagObjects;

use Helper, File, Session, Auth;

class VideoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Video::where('video.status', 1);
              
        if( $name != ''){
            $query->where('video.name_vi', 'LIKE', '%'.$name.'%');
            $query->orWhere('video.name_en', 'LIKE', '%'.$name.'%');
        }
        $items = $query->paginate(50);
        return view('backend.video.index', compact( 'items', 'arrSearch'));
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
        return view('backend.video.create', compact('tagViList', 'tagEnList'));
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
            //'slug_en' => 'required',
            'video_url' => 'required'
        ],
        [
            'name_vi.required' => 'Bạn chưa nhập tên video VI',
            'slug_vi.required' => 'Bạn chưa nhập slug VI',
            //'name_en.required' => 'Bạn chưa nhập tên video EN',
            //'slug_en.required' => 'Bạn chưa nhập slug EN',
            'video_url.required' => 'Bạn chưa nhập VIDEO URL',
        ]);        
        
        if($dataArr['image_url'] && $dataArr['image_name']){
            
            $tmp = explode('/', $dataArr['image_url']);

            if(!is_dir('public/uploads/'.date('Y/m/d'))){
                mkdir('public/uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('decoos.upload_path').$dataArr['image_url'], config('decoos.upload_path').$destionation);
            
            $dataArr['image_url'] = $destionation;
        } 

        $dataArr['alias_vi'] = Helper::stripUnicode($dataArr['name_vi']);
        $dataArr['alias_en'] = Helper::stripUnicode($dataArr['name_en']);
                   
        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;
        $rs = Video::create($dataArr);
        $id = $rs->id;

        // xu ly tags
        if( !empty( $dataArr['tags_vi'] ) && $id ){           

            foreach ($dataArr['tags_vi'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $id;
                $model->tag_id  = $tag_id;
                $model->object_type  = 3;
                $model->type = 1;
                $model->save();
            }
        }
        if( !empty( $dataArr['tags_en'] ) && $id ){           

            foreach ($dataArr['tags_en'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $id;
                $model->tag_id  = $tag_id;
                $model->object_type  = 3;
                $model->type = 2;
                $model->save();
            }
        }

        $this->storeMeta( $id, 0, $dataArr);

        Session::flash('message', 'Tạo mới video thành công');

        return redirect()->route('video.index');
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
        $detail = Video::find($id);

        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }
        $tagViList = Tag::where('type', 1)->orderBy('id', 'desc')->get();
        $tagEnList = Tag::where('type', 2)->orderBy('id', 'desc')->get();

        $tmpArr = TagObjects::where(['object_id' => $id, 'object_type' => 3])->get();
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
        return view('backend.video.edit', compact( 'detail', 'meta', 'tagViList', 'tagEnList', 'tagSelectedVi', 'tagSelectedEn'));
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
          //  'slug_en' => 'required'
        ],
        [
            'name_vi.required' => 'Bạn chưa nhập tên video VI',
            'slug_vi.required' => 'Bạn chưa nhập slug VI',
            //'name_en.required' => 'Bạn chưa nhập tên video EN',
           // 'slug_en.required' => 'Bạn chưa nhập slug EN',
        ]);

        if($dataArr['image_url'] && $dataArr['image_name']){
            
            $tmp = explode('/', $dataArr['image_url']);

            if(!is_dir('public/uploads/'.date('Y/m/d'))){
                mkdir('public/uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('decoos.upload_path').$dataArr['image_url'], config('decoos.upload_path').$destionation);
            
            $dataArr['image_url'] = $destionation;
        }
        $dataArr['alias_vi'] = Helper::stripUnicode($dataArr['name_vi']);
        $dataArr['alias_en'] = Helper::stripUnicode($dataArr['name_en']);
              
        $dataArr['updated_user'] = Auth::user()->id; 

        $model = Video::find($dataArr['id']);
        $model->update($dataArr);
        // xu ly tags
        TagObjects::where(['object_id' => $dataArr['id'], 'object_type' => 3])->delete();
        if( !empty( $dataArr['tags_vi'] ) && $dataArr['id'] ){           

          foreach ($dataArr['tags_vi'] as $tag_id) {
              $model = new TagObjects;
              $model->object_id = $dataArr['id'];
              $model->tag_id  = $tag_id;
              $model->type = 1;
              $model->object_type  = 3;
              $model->save();
          }
          }
          if( !empty( $dataArr['tags_en'] ) && $dataArr['id'] ){           

          foreach ($dataArr['tags_en'] as $tag_id) {
              $model = new TagObjects;
              $model->object_id = $dataArr['id'];
              $model->tag_id  = $tag_id;
              $model->object_type  = 3;
              $model->type = 2;
              $model->save();
          }
        }

        $this->storeMeta( $dataArr['id'], $dataArr['meta_id'], $dataArr);

        Session::flash('message', 'Cập nhật video thành công');

        return redirect()->route('video.edit', $dataArr['id']);
    }
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = [
            'title_vi' => $dataArr['meta_title_vi'], 
            'description_vi' => $dataArr['meta_description_vi'], 
            'keywords_vi'=> $dataArr['meta_keywords_vi'], 
            'custom_text_vi' => $dataArr['custom_text_vi'], 
            'title_en' => $dataArr['meta_title_en'], 
            'description_en' => $dataArr['meta_description_en'], 
            'keywords_en'=> $dataArr['meta_keywords_en'], 
            'custom_text_en' => $dataArr['custom_text_en'], 
            'updated_user' => Auth::user()->id
        ];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            
            $modelSp = Video::find( $id );
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
        $model = Video::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa video thành công');
        return redirect()->route('video.index');
    }   
}
