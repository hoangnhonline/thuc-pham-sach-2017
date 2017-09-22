<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\Articles;
use App\Models\ArticlesCate;
use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\Settings;
use App\Models\Album;
use App\Models\Video;

use App\Models\CustomerNotification;
use Helper, File, Session, Auth, Hash, App;

class HomeController extends Controller
{
    
    public static $loaiSpList = []; 
    public static $loaiSpListArrKey = [];    

    public function __construct(){

    }
    public function setLang(Request $request){
        $lang = $request->lang;        
        Session::put('locale', $lang);
    }    
    public function index(Request $request)
    {            
           
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
        $productArr = [];
        
        $loaiSpList = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        //public static function getList($is_hot, $is_sale, $cate_id, $loai_id, $limit
        $newProduct = Product::getList(0, 0, 0, 0, 4);        
        $hotProduct = Product::getList(1, 0, 0, 0, 4);
        $saleProduct = Product::getList(0, 1, 0, 0, 4);
        $albumList = Album::where('status', 1)->join('album_img', 'thumbnail_id', '=', 'album_img.id')
                                ->select('album.*', 'album_img.image_url')
                                ->orderBy('id', 'desc')->limit(4)->get();
        $videoList = Video::where('status', 1)->orderBy('id', 'desc')->limit(4)->get();
        
        $lang_id = $lang == 'vi' ? 1 : 2;
        $articlesList = Articles::where('status', 1)->where('lang_id', $lang_id)->orderBy('id', 'desc')->limit(4)->get();        

        foreach( $loaiSpList as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();
            $productArr[$loai->slug_vi] = Product::where(['status' => 1, 'loai_id' => $loai->id])
                                ->join('product_img', 'thumbnail_id', '=', 'product_img.id')
                                ->select('product.*', 'product_img.image_url')
                                ->orderBy('id', 'desc')->limit(8)->get();
            if($cateList[$loai->id]->count() > 0){
                foreach($cateList[$loai->id] as $cate){
                    $productArr[$cate->id] = Product::where(['status' => 1, 'cate_id' => $cate->id])
                                ->join('product_img', 'thumbnail_id', '=', 'product_img.id')
                                ->select('product.*', 'product_img.image_url')
                                ->orderBy('id', 'desc')->limit(8)->get();
                }
            }            
            
            $settingArr = Settings::whereRaw('1')->lists('value', 'name');
            $seo = $settingArr;
            $seo['title'] = $settingArr['site_title_'.$lang];
            $seo['description'] = $settingArr['site_description_'.$lang];
            $seo['keywords'] = $settingArr['site_keywords_'.$lang];
            $socialImage = $settingArr['banner'];
        }    
        //$articlesArr = Articles::where(['cate_id' => 1, 'is_hot' => 1])->orderBy('id', 'desc')->get();
                
        return view('frontend.home.index', compact('loaiSpList', 'cateList', 'productArr', 'socialImage', 'seo', 'newProduct', 'hotProduct', 'saleProduct', 'lang', 'albumList', 'videoList', 'articlesList'));
    }

    
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
        $tu_khoa = $request->keyword;       

        if($lang == 'vi'){
            $sql = Product::where('alias_vi', 'LIKE', '%'.$tu_khoa.'%');    
        }else{
            $sql = Product::where('alias_en', 'LIKE', '%'.$tu_khoa.'%');
        }
        
        $sql->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                        ->select('product_img.image_url', 'product.*')
                        ->orderBy('id', 'desc');
        $productArr = $sql->paginate(24);
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Tìm kiếm sản phẩm theo từ khóa '".$tu_khoa."'";        
        $loaiSp = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        foreach($loaiSp as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();
        }
        return view('frontend.search.index', compact('productArr', 'tu_khoa', 'seo', 'lang', 'loaiSp', 'cateList'));
    }
    public function ajaxTab(Request $request){
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
        $table = $request->type ? $request->type : 'category';
        $id = $request->id;

        $arr = Film::getFilmHomeTab( $table, $id);

        return view('frontend.index.ajax-tab', compact('arr'));
    }
    public function contact(Request $request){        

        $seo['title'] = 'Liên hệ';
        $seo['description'] = 'Liên hệ';
        $seo['keywords'] = 'Liên hệ';
        $socialImage = '';
        
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
        return view('frontend.contact.index', compact('seo', 'socialImage', 'lang'));
    }

    public function newsList(Request $request)
    {
        $slug = $request->slug;
        $cateArr = $cateActiveArr = $moviesActiveArr = [];
       
        $cateDetail = ArticlesCate::where('slug' , $slug)->first();

        $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;

        $articlesArr = Articles::where('cate_id', $cateDetail->id)->orderBy('id', 'desc')->paginate(10);

        $hotArr = Articles::where( ['cate_id' => $cateDetail->id, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
        $seo['title'] = $cateDetail->meta_title ? $cateDetail->meta_title : $cateDetail->title;
        $seo['description'] = $cateDetail->meta_description ? $cateDetail->meta_description : $cateDetail->title;
        $seo['keywords'] = $cateDetail->meta_keywords ? $cateDetail->meta_keywords : $cateDetail->title;
        $socialImage = $cateDetail->image_url;       
        return view('frontend.news.index', compact('title', 'hotArr', 'articlesArr', 'cateDetail', 'seo', 'socialImage'));
    }      

     public function newsDetail(Request $request)
    {     
        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'custom_text', 'created_at', 'cate_id')
                ->first();
        $is_km = $is_news = $is_kn = 0;
        if( $detail ){           

            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();
            $otherArr = Articles::where( ['cate_id' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();
            $seo['title'] = $detail->meta_title ? $detail->meta_title : $detail->title;
            $seo['description'] = $detail->meta_description ? $detail->meta_description : $detail->title;
            $seo['keywords'] = $detail->meta_keywords ? $detail->meta_keywords : $detail->title;
            $socialImage = $detail->image_url; 
            $is_km = $detail->cate_id == 2 ? 1 : 0;
            $is_news = $detail->cate_id == 1 ? 1 : 0;
            $is_kn = $detail->cate_id == 4 ? 1 : 0;
            return view('frontend.news.news-detail', compact('title',  'hotArr', 'detail', 'otherArr', 'seo', 'socialImage', 'is_km', 'is_news', 'is_kn'));
        }else{
            return view('erros.404');
        }
    }

    public function registerNews(Request $request)
    {

        $register = 0; 
        $email = $request->email;
        $newsletter = Newsletter::where('email', $email)->first();
        if(is_null($newsletter)) {
           $newsletter = new Newsletter;
           $newsletter->email = $email;
           $newsletter->is_member = Customer::where('email', $email)->first() ? 1 : 0;
           $newsletter->save();
           $register = 1;
        }

        return $register;
    }

}
