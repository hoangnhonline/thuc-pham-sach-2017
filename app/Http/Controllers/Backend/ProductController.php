<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\ProductImg;
use App\Models\MetaData;
use App\Models\Color;
use App\Models\Tag;
use App\Models\TagObjects;

use Helper, File, Session, Auth, Hash, URL;

class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {

        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;
        $arrSearch['is_hot'] = $is_hot = isset($request->is_hot) ? $request->is_hot : null;
        $arrSearch['is_sale'] = $is_sale = isset($request->is_sale) ? $request->is_sale : null;
        $arrSearch['loai_id'] = $loai_id = isset($request->loai_id) ? $request->loai_id : null;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : null;      
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Product::where('product.status', $status);
        if( $is_hot ){
            $query->where('product.is_hot', $is_hot);
        }
        if( $is_sale ){
            $query->where('product.is_sale', $is_sale);
        }
        if( $loai_id ){
            $query->where('product.loai_id', $loai_id);
        }
        if( $cate_id ){
            $query->where('product.cate_id', $cate_id);
        }       
        if( $name != ''){
            $query->where('product.name_vi', 'LIKE', '%'.$name.'%');
            $query->orWhere('product.name_en', 'LIKE', '%'.$name.'%');
        }
        $query->join('users', 'users.id', '=', 'product.created_user');
        $query->join('loai_sp', 'loai_sp.id', '=', 'product.loai_id');
        $query->leftJoin('cate', 'cate.id', '=', 'product.cate_id');
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id');        
        $query->orderBy('display_order')->orderBy('product.id', 'desc');
        $items = $query->select(['product_img.image_url','product.*','product.id as sp_id', 'full_name' , 'product.created_at as time_created', 'users.full_name', 'loai_sp.name_vi as ten_loai', 'cate.name_vi as ten_cate'])
        ->paginate(50);   

        $loaiSpArr = LoaiSp::all();  
        if( $loai_id ){
            $cateArr = Cate::where('loai_id', $loai_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }

        return view('backend.product.index', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr'));
    }    
    public function saveOrder(Request $request){

        $data = $request->all();
        if(!empty($data['display_order'])){
            foreach ($data['display_order'] as $key => $display_order) {
                $model = Product::find($data['product_id'][$key]);
                $model->display_order = $display_order;

                $model->save();
            }
        }
        Session::flash('message', 'Cập nhật thứ tự thành công');

        return redirect()->route('product.index', ['cate_id' => $data['cate_id'], 'loai_id' => $data['loai_id']]);
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $loai_id = $request->loai_id ? $request->loai_id : null;
        $cate_id = $request->cate_id ? $request->cate_id : null;
        $cateArr = $loaiThuocTinhArr = (object) [];
        $thuocTinhArr = [];
        $loaiSpArr = LoaiSp::all();
        $colorList = Color::all();
        
        if( $loai_id ){            
            $cateArr = Cate::where('loai_id', $loai_id)->select('id', 'name_vi')->orderBy('display_order', 'desc')->get();
        } 
        $tagViList = Tag::where('type', 1)->orderBy('id', 'desc')->get();
        $tagEnList = Tag::where('type', 2)->orderBy('id', 'desc')->get();

        return view('backend.product.create', compact('loaiSpArr', 'cateArr', 'loai_id', 'cate_id', 'colorList', 'tagViList', 'tagEnList'));
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
            'code' => 'required',
            'name_vi' => 'required',
            'slug_vi' => 'required' ,
            //'name_en' => 'required',
            //'slug_en' => 'required' ,
            'price' => 'numeric'           
        ],
        [
            'code.required' => 'Bạn chưa nhập mã sản phẩm',
            'name_vi.required' => 'Bạn chưa nhập tên sản phẩm tiếng Việt ',
            'slug_vi.required' => 'Bạn chưa nhập slug tiếng Việt',
           // 'name_en.required' => 'Bạn chưa nhập tên sản phẩm tiếng Anh',
            //'slug_en.required' => 'Bạn chưa nhập slug tiếng Anh',
            'price.numeric' => 'Vui lòng nhập giá hợp lệ'            
        ]);

        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;

        $dataArr['is_sale'] = isset($dataArr['is_sale']) ? 1 : 0;        
        
        $dataArr['slug_vi'] = str_replace(".", "-", $dataArr['slug_vi']);
        $dataArr['slug_vi'] = str_replace("(", "-", $dataArr['slug_vi']);
        $dataArr['slug_vi'] = str_replace(")", "", $dataArr['slug_vi']);

        $dataArr['slug_en'] = str_replace(".", "-", $dataArr['slug_en']);
        $dataArr['slug_en'] = str_replace("(", "-", $dataArr['slug_en']);
        $dataArr['slug_en'] = str_replace(")", "", $dataArr['slug_en']);

        $dataArr['alias_vi'] = Helper::stripUnicode($dataArr['name_vi']);
        $dataArr['alias_en'] = Helper::stripUnicode($dataArr['name_en']); 

        $dataArr['content_vi'] = str_replace("[Caption]", "", $dataArr['content_vi']);
        $dataArr['content_en'] = str_replace("[Caption]", "", $dataArr['content_en']);
        
        $dataArr['status'] = 1;
        $dataArr['display_order'] = Helper::getNextOrder('product', ['loai_id' => $dataArr['loai_id'], 'cate_id' => $dataArr['cate_id']]);

        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;    

        $rs = Product::create($dataArr);     
        $sp_id = $rs->id;

        // xu ly tags
        if( !empty( $dataArr['tags_vi'] ) && $sp_id ){           

            foreach ($dataArr['tags_vi'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $sp_id;
                $model->tag_id  = $tag_id;
                $model->object_type  = 1;
                $model->type = 1;
                $model->save();
            }
        }
        if( !empty( $dataArr['tags_en'] ) && $sp_id ){           

            foreach ($dataArr['tags_en'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $sp_id;
                $model->tag_id  = $tag_id;
                $model->object_type  = 1;
                $model->type = 2;
                $model->save();
            }
        }
        $this->storeImage( $sp_id, $dataArr);
        $this->storeMeta($sp_id, 0, $dataArr);
        Session::flash('message', 'Tạo mới sản phẩm thành công');

        return redirect()->route('product.index', ['loai_id' => $dataArr['loai_id'], 'cate_id' => $dataArr['cate_id']]);
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
            $modelSp = Product::find( $id );
            $modelSp->meta_id = $meta_id;
            $modelSp->save();
        }else {
            $model = MetaData::find($meta_id);
            $model->update( $arrData );
        }              
    }    
    public function storeImage($id, $dataArr){        
        //process old image
        $imageIdArr = isset($dataArr['image_id']) ? $dataArr['image_id'] : [];
        $hinhXoaArr = ProductImg::where('product_id', $id)->whereNotIn('id', $imageIdArr)->lists('id');
        if( $hinhXoaArr )
        {
            foreach ($hinhXoaArr as $image_id_xoa) {
                $model = ProductImg::find($image_id_xoa);
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
                    $rs = ProductImg::create(['product_id' => $id, 'image_url' => $name, 'display_order' => 1]);                
                    $image_id = $rs->id;
                    if( $imageArr['is_thumbnail'][$key] == 1){
                        $thumbnail_id = $image_id;
                    }
                }
            }
            $model = Product::find( $id );
            $model->thumbnail_id = $thumbnail_id;
            $model->save();
        }
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
        $thuocTinhArr = $phuKienArr = $soSanhArr = $tuongTuArr = [];
        $hinhArr = (object) [];
        $detail = Product::find($id);

        $hinhArr = ProductImg::where('product_id', $id)->lists('image_url', 'id');      

        $loaiSpArr = LoaiSp::all();
            
        $loai_id = $detail->loai_id; 
            
        $cateArr = Cate::where('loai_id', $loai_id)->select('id', 'name_vi')->orderBy('display_order', 'desc')->get();
        $colorList = Color::all();
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }
        $tagViList = Tag::where('type', 1)->orderBy('id', 'desc')->get();
        $tagEnList = Tag::where('type', 2)->orderBy('id', 'desc')->get();
        
        $tmpArr = TagObjects::where(['object_id' => $id, 'object_type' => 1])->get();
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

        return view('backend.product.edit', compact( 'detail', 'hinhArr', 'loaiSpArr', 'cateArr', 'meta', 'colorList', 'tagViList', 'tagEnList', 'tagSelectedVi', 'tagSelectedEn'));
    }
    public function ajaxDetail(Request $request)
    {       
        $id = $request->id;
        $detail = Product::find($id);
        return view('backend.product.ajax-detail', compact( 'detail' ));
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
            'code' => 'required',
            'name_vi' => 'required',
            'slug_vi' => 'required' ,
            //'name_en' => 'required',
            //'slug_en' => 'required' ,
            'price' => 'numeric'           
        ],
        [
            'code.required' => 'Bạn chưa nhập mã sản phẩm',
            'name_vi.required' => 'Bạn chưa nhập tên sản phẩm tiếng Việt ',
            'slug_vi.required' => 'Bạn chưa nhập slug tiếng Việt',
            //'name_en.required' => 'Bạn chưa nhập tên sản phẩm tiếng Anh',
            //'slug_en.required' => 'Bạn chưa nhập slug tiếng Anh',
            'price.numeric' => 'Vui lòng nhập giá hợp lệ',            
        ]);
        
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;
        $dataArr['is_sale'] = isset($dataArr['is_sale']) ? 1 : 0;                
        $dataArr['slug_vi'] = str_replace(".", "-", $dataArr['slug_vi']);
        $dataArr['slug_vi'] = str_replace("(", "-", $dataArr['slug_vi']);
        $dataArr['slug_vi'] = str_replace(")", "", $dataArr['slug_vi']);

        $dataArr['slug_en'] = str_replace(".", "-", $dataArr['slug_en']);
        $dataArr['slug_en'] = str_replace("(", "-", $dataArr['slug_en']);
        $dataArr['slug_en'] = str_replace(")", "", $dataArr['slug_en']);

        $dataArr['alias_vi'] = Helper::stripUnicode($dataArr['name_vi']);
        $dataArr['alias_en'] = Helper::stripUnicode($dataArr['name_en']);

        $dataArr['updated_user'] = Auth::user()->id;
        
        $dataArr['content_vi'] = str_replace("[Caption]", "", $dataArr['content_vi']);
        $dataArr['content_en'] = str_replace("[Caption]", "", $dataArr['content_en']);
        
        $model = Product::find($dataArr['id']);

        $model->update($dataArr);
        
        $sp_id = $dataArr['id'];
        // xu ly tags
        TagObjects::where(['object_id' => $sp_id, 'object_type' => 1])->delete();
        if( !empty( $dataArr['tags_vi'] ) && $sp_id ){           

            foreach ($dataArr['tags_vi'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $sp_id;
                $model->tag_id  = $tag_id;
                $model->type = 1;
                $model->object_type  = 1;
                $model->save();
            }
        }
        if( !empty( $dataArr['tags_en'] ) && $sp_id ){           

            foreach ($dataArr['tags_en'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $sp_id;
                $model->tag_id  = $tag_id;
                $model->object_type  = 1;
                $model->type = 2;
                $model->save();
            }
        }

        $this->storeMeta( $sp_id, $dataArr['meta_id'], $dataArr);
        $this->storeImage( $sp_id, $dataArr);
     
        Session::flash('message', 'Chỉnh sửa sản phẩm thành công');

        return redirect()->route('product.edit', $sp_id);
        
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
        $model = Product::find($id);        
        $model->delete();
        ProductImg::where('product_id', $id)->delete();      
        // redirect
        Session::flash('message', 'Xóa sản phẩm thành công');
        
        return redirect(URL::previous());//->route('product.short');
        
    }
}
