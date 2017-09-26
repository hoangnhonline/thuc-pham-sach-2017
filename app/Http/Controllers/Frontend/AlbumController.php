<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Settings;
use App\Models\Album;
use App\Models\AlbumImg;
use App\Models\MetaData;
use App\Models\Product;

use App\Models\CustomerNotification;
use Helper, File, Session, Auth, Hash;

class AlbumController extends Controller
{
    
    public static $loaiSp = []; 
    public static $loaiSpArrKey = [];    

    public function __construct(){

    }
    
    public function loadSlider(){
        return view('frontend.home.ajax-slider');
    }
    public function index(Request $request){  
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
        $albumList = Album::where('status', 1)->join('album_img', 'thumbnail_id', '=', 'album_img.id')
                                ->select('album.*', 'album_img.image_url')
                                ->orderBy('id', 'desc')->paginate(24);

        $seo['title'] = $seo['description'] = $seo['keywords'] = $lang == 'vi' ? "Thư viện ảnh" : "Album";

          //sale product
        $saleList = Product::where(['is_sale' => 1])->where('price_sale', '>', 0)                    
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
                    ->select('product_img.image_url', 'product.*')->orderBy('id', 'desc')->limit(5)->get();
        $loaiSp = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        foreach($loaiSp as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();
        }
        return view('frontend.album.index', compact('albumList', 'seo', 'lang', 'loaiSp', 'cateList', 'saleList'
            ));
    }
    public function detail(Request $request)
    {             
  
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
        $productArr = [];
        $id = $request->id;
        $detail = Album::find($id);
        if(!$detail){
            return redirect()->route('home');
        }

        $hinhArr = AlbumImg::where('album_id', $detail->id)->get()->toArray();                                

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


        return view('frontend.album.detail', compact('detail', 'hinhArr', 'seo', 'lang', 
            'loaiSp', 'cateList', 'saleList'
            ));
    }

    
}
