<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use App\Models\Product;
use App\Models\LoaiSp;
use App\Models\Cate;

use Helper, File, Session, Auth;
use Mail;

class PageController extends Controller
{
    public function index(Request $request)
    {

        $lang = Session::get('locale') ? Session::get('locale') : 'vi';
       $slug = $request->slug;
       $detail = Pages::where('slug_vi', $slug)->orWhere('slug_en', $slug)->first();
       
       if(!$detail){
          return redirect()->route('home');
       }
       $saleList = Product::where(['is_sale' => 1])->where('price_sale', '>', 0)                    
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
                    ->select('product_img.image_url', 'product.*')->orderBy('id', 'desc')->limit(5)->get();
        $loaiSp = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        foreach($loaiSp as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();
        }
        return view('frontend.pages.index', compact('detail', 'lang', 'loaiSp', 'cateList', 'saleList', 'slug'
            ));
    }
}

