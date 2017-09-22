<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Text;
use Helper, File, Session, Auth;

class TextController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $title = isset($request->title) && $request->title != '' ? $request->title : '';
        
        $query = Text::whereRaw('1');

        if( $lang_id > 0){
            $query->where('lang_id', $lang_id);
        }
        
        if( $title != ''){
            $query->where('alias', 'LIKE', '%'.$title.'%');
        }
        $items = $query->orderBy('id', 'desc')->paginate(20);
        
        return view('backend.articles.index', compact( 'items', 'title', 'lang_id' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {


        return view('backend.text.create');
    }
    public function ajaxTag(Request $request){

        $type = $request->type ? $request->type : 1; // 1 = tieng viet 

        $tagList = Tag::where('type', $type)->orderBy('id', 'desc')->get();

        return view('backend.articles.ajax-tag', compact('tagList'));
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
        
        if(!empty($dataArr['text_key'])){
            foreach($dataArr['text_key'] as $k => $text_key){
                if($dataArr['text_vi'][$k] != '' && $dataArr['text_en'][$k] != ''){
                    $input['text_key'] = $text_key;
                    $input['text_vi'] = $dataArr['text_vi'][$k];
                    $input['text_en'] = $dataArr['text_en'][$k];
                    Text::create($input);
                }
            }
        }        

        return redirect()->route('text.create');
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
        $tagSelected = [];

        $detail = Text::find($id);
        
        $cateArr = TextCate::all();        

        $tmpArr = TagObjects::where(['type' => $detail->lang_id, 'object_id' => $id, 'object_type' => 4])->get();
        
        if( $tmpArr->count() > 0 ){
            foreach ($tmpArr as $value) {
                $tagSelected[] = $value->tag_id;
            }
        }
        
        $tagArr = Tag::where('type', $detail->lang_id)->get();

        return view('backend.articles.edit', compact('tagArr', 'tagSelected', 'detail', 'cateArr' ));
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
            'lang_id' => 'required',            
            'title' => 'required',            
            'slug' => 'required|unique:articles,slug,'.$dataArr['id'],
        ],
        [            
            'lang_id.required' => 'Bạn chưa chọn danh mục',            
            'title.required' => 'Bạn chưa nhập tiêu đề',
            'slug.required' => 'Bạn chưa nhập slug',
            'slug.unique' => 'Slug đã được sử dụng.'
        ]);       
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['title']);
        
        if($dataArr['image_url'] && $dataArr['image_name']){
            
            $tmp = explode('/', $dataArr['image_url']);

            if(!is_dir('public/uploads/'.date('Y/m/d'))){
                mkdir('public/uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('decoos.upload_path').$dataArr['image_url'], config('decoos.upload_path').$destionation);
            
            $dataArr['image_url'] = $destionation;
        }

        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;  
        //$dataArr['status'] = isset($dataArr['status']) ? 1 : 0;  
        $model = Text::find($dataArr['id']);

        $model->update($dataArr);

        TagObjects::where(['object_id' => $dataArr['id'], 'object_type' => 4])->delete();
        // xu ly tags
        if( !empty( $dataArr['tags'] ) ){
                       
            foreach ($dataArr['tags'] as $tag_id) {
                $modelTagObject = new TagObjects; 
                $modelTagObject->object_id = $dataArr['id'];
                $modelTagObject->tag_id  = $tag_id;
                $modelTagObject->type = $dataArr['lang_id'];
                $modelTagObject->object_type = 4;
                $modelTagObject->save();
            }
        }
        Session::flash('message', 'Cập nhật tin tức thành công');        

        return redirect()->route('articles.edit', $dataArr['id']);
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
        $model = Text::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa tin tức thành công');
        return redirect()->route('articles.index');
    }
}
