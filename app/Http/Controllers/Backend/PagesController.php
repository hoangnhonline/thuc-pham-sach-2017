<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use App\Models\MetaData;
use App\Models\Tag;
use App\Models\TagObjects;

use Helper, File, Session, Auth;

class PagesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Pages::where('pages.status', 1);
              
        if( $name != ''){
            $query->where('pages.title_vi', 'LIKE', '%'.$name.'%');
            $query->orWhere('pages.title_en', 'LIKE', '%'.$name.'%');
        }
        $items = $query->paginate(50);
        return view('backend.pages.index', compact( 'items', 'arrSearch'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.pages.create');
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
            'title_vi' => 'required',
            'slug_vi' => 'required',
            //'title_en' => 'required',
            //'slug_en' => 'required'            
        ],
        [
            'title_vi.required' => 'Bạn chưa nhập tên trang VI',
            'slug_vi.required' => 'Bạn chưa nhập slug VI',
           // 'title_en.required' => 'Bạn chưa nhập tên trang EN',
           // 'slug_en.required' => 'Bạn chưa nhập slug EN'            
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

        $dataArr['alias_vi'] = Helper::stripUnicode($dataArr['title_vi']);
        $dataArr['alias_en'] = Helper::stripUnicode($dataArr['title_en']);
                   
        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;
        $rs = Pages::create($dataArr);
        $id = $rs->id;       

        $this->storeMeta( $id, 0, $dataArr);

        Session::flash('message', 'Tạo mới pages thành công');

        return redirect()->route('pages.index');
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
        $detail = Pages::find($id);

        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }
        
        return view('backend.pages.edit', compact( 'detail', 'meta'));
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
            'title_vi' => 'required',
            'slug_vi' => 'required',
           // 'title_en' => 'required',
            //'slug_en' => 'required'
        ],
        [
            'title_vi.required' => 'Bạn chưa nhập tên trang VI',
            'slug_vi.required' => 'Bạn chưa nhập slug VI',
            //'title_en.required' => 'Bạn chưa nhập tên trang EN',
            //'slug_en.required' => 'Bạn chưa nhập slug EN',
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
        $dataArr['alias_vi'] = Helper::stripUnicode($dataArr['title_vi']);
        $dataArr['alias_en'] = Helper::stripUnicode($dataArr['title_en']);
            
        $dataArr['updated_user'] = Auth::user()->id; 

        $model = Pages::find($dataArr['id']);
        $model->update($dataArr);        

        $this->storeMeta( $dataArr['id'], $dataArr['meta_id'], $dataArr);

        Session::flash('message', 'Cập nhật trang thành công');

        return redirect()->route('pages.edit', $dataArr['id']);
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
            
            $modelSp = Pages::find( $id );
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
        $model = Pages::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa trang thành công');
        return redirect()->route('pages.index');
    }   
}
