<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Settings;
use App\Models\Video;
use App\Models\MetaData;
use App\Models\Product;

use App\Models\CustomerNotification;
use Helper, File, Session, Auth, Hash;

class VideoController extends Controller
{
    
    public static $loaiSp = []; 
    public static $loaiSpArrKey = [];    

    public function __construct(){

    }
    
    public function loadSlider(){
        return view('frontend.home.ajax-slider');
    }
    public function index(Request $request){
        $lang = 'vi';        
        $videoList = Video::where('status', 1)->orderBy('id', 'desc')->paginate(24);

        $seo['title'] = $seo['description'] = $seo['keywords'] = "Video";

          //sale product
        $saleList = Product::where(['is_sale' => 1])->where('price_sale', '>', 0)                    
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
                    ->select('product_img.image_url', 'product.*')->orderBy('id', 'desc')->limit(5)->get();
        $loaiSp = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        foreach($loaiSp as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();
        }
        return view('frontend.video.index', compact('videoList', 'seo', 'lang', 'loaiSp', 'cateList', 'saleList'
            ));
    }
    public function detail(Request $request)
    {             
     
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
        $id = $request->id;
        $detail = Video::find($id);
        if(!$detail){
            return redirect()->route('home');
        }
       
        if( $detail->meta_id > 0){
           $meta = MetaData::find( $detail->meta_id )->toArray();
           $seo['title'] = $meta['title_'.$lang] != '' ? $meta['title_'.$lang] : $detail->name_vi;
           $seo['description'] = $meta['description_'.$lang] != '' ? $meta['description_'.$lang] : $detail->name_vi;
           $seo['keywords'] = $meta['keywords_'.$lang] != '' ? $meta['keywords_'.$lang] : $detail->name_vi;
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $detail->name_vi;
        }               

        $loaiSp = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        foreach($loaiSp as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();
        }

         //sale product
        $saleList = Product::where(['is_sale' => 1, 'cate_id' => $detail->cate_id])->where('price_sale', '>', 0)
                    ->where('product.id', '<>', $id)
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
                    ->select('product_img.image_url', 'product.*')->orderBy('id', 'desc')->limit(5)->get();


        return view('frontend.video.detail', compact('detail', 'hinhArr', 'seo', 'lang', 'loaiSp', 'cateList', 'saleList'));
    }

    
}
