<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Product;
use App\Models\MetaData;
use App\Models\Tag;
use App\Models\TagObjects;

use Helper, File, Session, Auth, DB;

class OtherController extends Controller
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
    public function tag(Request $request)
    {   
   
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';     
        $productArr = [];
        $slug = $request->slug;        
        $rs = Tag::where('slug', $slug)->first();
        if(!$rs){
            return redirect()->route('home');
        }
        $tag_id = $rs->id;
        
        $socialImage = $rs->icon_url;

        if( $rs->meta_id > 0){            
           $seo = MetaData::find( $rs->meta_id )->toArray();           
        }else{
            $seo['title'] = $seo['description'] = $seo['keywords'] = $lang == 'vi' ? $rs->name_vi : $rs->name_en;
        }
        
        $loaiSp = LoaiSp::where('status', 1)->orderBy('display_order')->get();
        foreach($loaiSp as $loai){
            $cateList[$loai->id] = Cate::where('loai_id', $loai->id)->orderBy('display_order')->get();            
        }      
          
        $query = TagObjects::where('tag_id', $tag_id)
                ->join('product', 'product.id', '=', 'tag_objects.object_id')
                ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
                ->select('product_img.image_url', 'product.*');                              
        $query->orderBy('product.id', 'desc');
        

        $productArr = $query->paginate(24);
       
        //sale product
        $saleList = Product::where('is_sale', 1)->where('price_sale', '>', 0)
                    ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')                
                    ->select('product_img.image_url', 'product.*')->orderBy('id', 'desc')->limit(5)->get();
        return view('frontend.tag.index', compact(
                    'productArr', 
                    'cateArr', 
                    'rs',
                    'socialImage', 
                    'seo', 
                    'loaiSp', 
                    'cateList', 
                    'lang',
                    'saleList'
                    )
        );
    }

}
