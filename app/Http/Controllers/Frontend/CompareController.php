<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Product;
use App\Models\SpThuocTinh;
use App\Models\ProductImg;
use App\Models\ThuocTinh;
use App\Models\LoaiThuocTinh;
use App\Models\Banner;
use App\Models\Location;
use App\Models\TinhThanh;

use Helper, File, Session, Auth;

class CompareController extends Controller
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
       

        $spThuocTinhArr = $productArr = [];
        $str_id = $request->id;
        if( $str_id ){
            $tmpArr = explode("-", $str_id);
            $productTmpArr = Product::whereIn('product.id', $tmpArr)
                ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                ->select('product.id as product_id', 'name_vi', 'slug_vi', 'name_en', 'slug_en', 'price', 'price_sale', 'product_img.image_url')->get();                
        
            foreach($productTmpArr as $product){
                $productArr[$product->product_id] = $product;
            }
            foreach( $tmpArr as $product_id){                
                $tmp = SpThuocTinh::where('product_id', $product_id)->select('thuoc_tinh')->first();
        
                if( $tmp ){
                    $spThuocTinhArr[$product_id] = json_decode( $tmp->thuoc_tinh, true);
                }
                $tmpDetail = Product::find( $product_id );
                $loai_id = $tmpDetail->loai_id;
            }
        }        
        
        $loaiThuocTinhArr = LoaiThuocTinh::where('loai_id', $loai_id)->orderBy('display_order')->get();        

        if( $loaiThuocTinhArr->count() > 0){
            foreach ($loaiThuocTinhArr as $value) {

                $thuocTinhArr[$value->id]['id'] = $value->id;
                $thuocTinhArr[$value->id]['name'] = $value->name;

                $thuocTinhArr[$value->id]['child'] = ThuocTinh::where('loai_thuoc_tinh_id', $value->id)->select('id', 'name')->orderBy('display_order')->get()->toArray();
            }
            
        }        

      
         $seo['title'] = $seo['description'] = $seo['keywords'] = "So sanh";         
        return view('frontend.compare.index', compact('thuocTinhArr', 'loaiThuocTinhArr', 'spThuocTinhArr', 'productArr', 'seo'));
    }


}
