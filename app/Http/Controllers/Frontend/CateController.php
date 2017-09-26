<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\Pages;
use App\Models\MetaData;
use App\Models\Color;
use Helper, File, Session, Auth, DB;

class CateController extends Controller
{
    
    public static $loaiSp = []; 
    public static $loaiSpArrKey = [];    

    public function __construct(){

    }
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {   

        $lang = Session::get('locale') ? Session::get('locale') : 'vi';     
        $productArr = [];
        $slug = $request->slug;        
        $rs = LoaiSp::where('slug_vi', $slug)->orWhere('slug_en', $slug)->first();
        if(!$rs){
            return redirect()->route('home');
        }
        $loai_id = $rs->id;
        
        $socialImage = $rs->icon_url;
        if( $rs->meta_id > 0){                            
           $seo = MetaData::find( $rs->meta_id )->toArray();           
           $seo['title'] = $seo['title_'.$lang];
           $seo['description'] = $seo['description_'.$lang];
           $seo['keywords'] = $seo['keywords_'.$lang];
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $lang == 'vi' ? $rs->name_vi : $rs->name_en;
        }
        
        $loaiSp = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        foreach($loaiSp as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();            
        }

        $productCount = [];
        if($cateList[$rs->id]->count() > 0){
            foreach($cateList[$rs->id] as $cate){
                $productCount[$cate->id] = Product::where(['status' => 1, 'cate_id' => $cate->id])->count();
            }
        }

        $colorList = Color::all();        

        $maxPriceObj = Product::where('loai_id', $loai_id)->orderBy('price', 'desc')->first();
        if($maxPriceObj){
            $maxPrice = $maxPriceObj->price;
        }else{
            $maxPrice = -1;
        }

        $p_from = $request->pf ? $request->pf : 0;
        $p_to = $request->pt ? $request->pt : $maxPrice;
        $mid = $request->mid ? $request->mid : '';
        $cid = $request->cid ? $request->cid : '';
          
        $query = Product::where('loai_id', $loai_id)
                ->where('price', '>=', $p_from)                
                ->where('price', '<=', $p_to);
        $cateSelected = $colorSelected = (object) [];
        if($cid > 0){
            $query->where('cate_id', $cid);
            $cateSelected = Cate::find($cid);
        }
        if($mid > 0){
            $query->where('color_id', $mid);
            $colorSelected = Color::find($mid); 
        };
            
        $s = $request->s ? $request->s : 1; // sort
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
            ->select('product_img.image_url', 'product.*'); 
        $query->orderBy('product.display_order');                     
        if($s == 1){       
            $query->orderBy('product.id', 'desc');
        }elseif($s == 2){
            $query->orderBy('product.id', 'asc');
        }elseif($s == 3){
            $query->orderBy('price', 'desc');
        }else{
            $query->orderBy('price', 'asc');
        }

        $ip = $request->ip ? $request->ip : 24; // item per page

        $productArr = $query->paginate($ip);

        $productColorCount = [];
        foreach($colorList as $color){
            $queryColor = Product::where(['status' => 1, 'color_id' => $color->id, 'loai_id' => $loai_id])
                            ->where('price', '>=', $p_from)
                            ->where('price', '<=', $p_to);        
                    if($cid > 0){
                        $queryColor->where('cate_id', $cid);
                    }
                    $productColorCount[$color->id] =  $queryColor->count();
        }
        //sale product
        $saleList = Product::where(['is_sale' => 1, 'loai_id' => $loai_id])->where('price_sale', '>', 0)
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
                    ->select('product_img.image_url', 'product.*')->orderBy('id', 'desc')->limit(5)->get();
        return view('frontend.cate.parent', compact(
                    'productArr', 
                    'cateArr', 
                    'rs',
                    'socialImage', 
                    'seo', 
                    'loaiSp', 
                    'cateList', 
                    'lang', 
                    'productCount', 
                    'cateSelected',
                    'colorSelected',
                    'saleList',
                    'productColorCount', 'colorList', 'maxPrice', 'p_from', 'p_to', 'mid', 'cid', 'ip', 's')
        );
    }

    public function cate(Request $request)
    {        
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
        $productArr = [];
        $slugLoaiSp = $request->slugLoaiSp;
        $slug = $request->slug;
        $rs = LoaiSp::where('slug_vi', $slugLoaiSp)->orWhere('slug_en', $slugLoaiSp)->first();
        if(!$rs){
            return redirect()->route('home');
        }
        $loai_id = $rs->id;
        
        $rsCate = Cate::where(['loai_id' => $loai_id, 'slug_vi' => $slug])->orWhere('slug_en', $slug)->first();

        $cate_id = $rsCate->id;

        //sale product
        $saleList = Product::where(['is_sale' => 1, 'cate_id' => $cate_id])->where('price_sale', '>', 0)
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
                    ->select('product_img.image_url', 'product.*')->orderBy('id', 'desc')->limit(5)->get();

        $cateArr = Cate::where('status', 1)->where('loai_id', $loai_id)->get();
        
        $socialImage = $rsCate->icon_url;
        if( $rsCate->meta_id > 0){                 
           $seo = MetaData::find( $rsCate->meta_id )->toArray();          
           $seo['title'] = $seo['title_'.$lang];
           $seo['description'] = $seo['description_'.$lang];
           $seo['keywords'] = $seo['keywords_'.$lang];         
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $lang == 'vi' ? $rsCate->name_vi : $rsCate->name_en;
        }
        
        $loaiSp = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        foreach($loaiSp as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();
        }
        // get all color list
        $colorList = Color::all();        
        // cal max price
        $maxPriceObj = Product::where('loai_id', $loai_id)->orderBy('price', 'desc')->first();
        if($maxPriceObj){
            $maxPrice = $maxPriceObj->price;
        }else{
            $maxPrice = -1;
        }
        
        $p_from = $request->pf ? $request->pf : 0;
        $p_to = $request->pt ? $request->pt : $maxPrice;
        $mid = $request->mid ? $request->mid : '';       
        
        $productColorCount = [];
        foreach($colorList as $color){
            $productColorCount[$color->id] = Product::where(['status' => 1, 'color_id' => $color->id, 'loai_id' => $loai_id, 'cate_id' => $cate_id])
                            ->where('price', '>=', $p_from)
                            ->where('price', '<=', $p_to)
                            ->count();
        }       
          
        $query = Product::where('loai_id', $loai_id)
                ->where('price', '>=', $p_from)                
                ->where('price', '<=', $p_to)        
                ->where('cate_id', $cate_id);
        $colorSelected = (object) [];
        if($mid > 0){
            $query->where('color_id', $mid);   
            $colorSelected = Color::find($mid);
        };
            
        $s = $request->s ? $request->s : 1; // sort
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
            ->select('product_img.image_url', 'product.*');
        $query->orderBy('product.display_order');                                           
        if($s == 1){       
            $query->orderBy('product.id', 'desc');
        }elseif($s == 2){
            $query->orderBy('product.id', 'asc');
        }elseif($s == 3){
            $query->orderBy('price', 'desc');
        }else{
            $query->orderBy('price', 'asc');
        }

        $ip = $request->ip ? $request->ip : 24; // item per page

        $productArr = $query->paginate($ip);

        return view('frontend.cate.child', compact('productArr', 'cateArr', 'rs', 'rsCate', 'socialImage', 'seo', 'loaiSp', 'cateList', 'lang', 
            'maxPrice',
            'productColorCount',
            'p_from',
            'p_to', 
            's',
            'ip',
            'mid',
            'colorList',
            'colorSelected',
            'saleList'
            ));
    } 
  
    public function ajaxTab(Request $request){
        $table = $request->type ? $request->type : 'category';
        $id = $request->id;

        $arr = Film::getFilmHomeTab( $table, $id);

        return view('frontend.index.ajax-tab', compact('arr'));
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {

        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        
        $layout_name = "main-category";
        
        $page_name = "page-category";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];

        $tu_khoa = $request->k;
        
        $is_search = 1;

        $moviesArr = Film::where('alias', 'LIKE', '%'.$tu_khoa.'%')->orderBy('id', 'desc')->paginate(20);

        return view('frontend.cate', compact('settingArr', 'moviesArr', 'tu_khoa',  'is_search', 'layout_name', 'page_name' ));
    }    

    public function newsList(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $layout_name = "main-news";
        
        $page_name = "page-news";

        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $cateDetail = ArticlesCate::where('slug' , 'tin-tuc')->first();
        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;

        $articlesArr = Articles::where('cate_id', 1)->orderBy('id', 'desc')->paginate(10);
        $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
        return view('frontend.news-list', compact('title','settingArr', 'hotArr', 'layout_name', 'page_name', 'articlesArr'));
    }

    public function newsDetail(Request $request)
    {
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $layout_name = "main-news";
        
        $page_name = "page-news";

        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'custom_text')
                ->first();
        if(!$detail){
            return redirect()->route('home');
        }

        if( $detail ){
            $cateArr = $cateActiveArr = $moviesActiveArr = [];
        
            
            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();

            return view('frontend.news-detail', compact('title', 'settingArr', 'hotArr', 'layout_name', 'page_name', 'detail'));
        }else{
            return view('erros.404');
        }     

        
    }

}
