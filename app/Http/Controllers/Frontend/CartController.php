<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\City;
use App\Models\Banner;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Settings;


use Helper, File, Session, Auth;
use Mail;

class CartController extends Controller
{

    public static $loaiSp = [];
    public static $loaiSpArrKey = [];


    /**
    * Session products define array [ id => quantity ]
    *
    */

    public function __construct(){
        // Session::put('products', [
        //     '1' => 2,
        //     '3' => 3
        // ]);
        // Session::put('login', true);
        // Session::put('userId', 1);
        // Session::forget('login');
        // Session::forget('userId');

    } 
    public function index(Request $request)
    {   
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';     
        if(!Session::has('products')) {
            return redirect()->route('home');
        }
        
        $getlistProduct = Session::get('products');
        $listProductId = array_keys($getlistProduct);
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Giỏ hàng";
        
        return view('frontend.cart.index', compact('arrProductInfo', 'getlistProduct', 'seo', 'lang'));
    }

    public function update(Request $request)
    {
        $listProduct = Session::get('products');
        if($request->quantity) {
            $listProduct[$request->id] = $request->quantity;
        } else {
            unset($listProduct[$request->id]);
        }
        Session::put('products', $listProduct);
        return 'sucess';
    }

    public function addProduct(Request $request)
    {
        $listProduct = Session::get('products');

        if(!empty($listProduct[$request->id])) {
            $listProduct[$request->id] += 1;
        } else {
            $listProduct[$request->id] = 1;
        }

        Session::put('products', $listProduct);

        return 'sucess';
    }

    public function shippingStep1(Request $request)
    {
         $lang = Session::get('locale') ? Session::get('locale') : 'vi';   
        $getlistProduct = Session::get('products');
        //$chon_dich_vu = $request->chon_dich_vu;
        $so_dich_vu = $request->so_dich_vu;
        $phi_dich_vu = $request->phi_dich_vu;        
        $listProductId = array_keys($getlistProduct);
        /*
        $service_fee = [];
        $totalServiceFee = 0;
        foreach($listProductId as $product_id){
            if(isset($chon_dich_vu[$product_id]) && $chon_dich_vu[$product_id] == 1){
                $service_fee[$product_id]['fee'] = $so_dich_vu[$product_id]*$phi_dich_vu[$product_id];
                $service_fee[$product_id]['so_luong'] = $so_dich_vu[$product_id];
                $service_fee[$product_id]['don_gia_dich_vu'] = $phi_dich_vu[$product_id];
                $totalServiceFee+= $service_fee[$product_id]['fee'];
            }
        }
        */
        //Session::set('service_fee', $service_fee);
        //Session::set('totalServiceFee', $totalServiceFee);
        
        if(Session::get('login') || Session::get('new-register')) {
            return redirect()->route('shipping-step-2');
        }

        if(empty($getlistProduct)) {
            return redirect()->route('home');
        }
        
        $listProductId = array_keys($getlistProduct);

       
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();
        
        $seo = Helper::seo();
        return view('frontend.cart.shipping-step-1', compact('arrProductInfo', 'getlistProduct' , 'seo', 'lang'));
    }

    public function shippingStep2(Request $request)
    {
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';    
        $getlistProduct = Session::get('products');
        
        if((empty($getlistProduct) || !Session::get('login')) && !Session::has('new-register') )  {
            return redirect()->route('home');
        }
        

        $listProductId = $getlistProduct ? array_keys($getlistProduct) : [];
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();
        $listCity = City::orderBy('display_order')->get();
        $listCountry = Country::orderBy('id')->get();
        
        $userId = Session::get('userId');
        $customer = Customer::find($userId);
        
        $totalServiceFee = 0;
        if(is_null($customer)) $customer = new Customer;
        $city_default = $customer->city_id > 0 ? $customer->city_id : 294;
        $seo = Helper::seo();
        
        return view('frontend.cart.shipping-step-2', compact('customer', 'listCity', 'seo', 'getlistProduct', 'arrProductInfo', 'lang', 'listCountry', 'city_default'));
    }

    public function updateUserInformation(Request $request)
    {
         $lang = Session::get('locale') ? Session::get('locale') : 'vi';   
        $getlistProduct = Session::get('products');

        $listProductId = $getlistProduct ? array_keys($getlistProduct) : [];

        $listCity = City::orderBy('display_order')->get();

        $userId = Session::get('userId');
        $customer = Customer::find($userId);

        if(is_null($customer)) $customer = new Customer;
        $seo = Helper::seo();
        return view('frontend.cart.register-infor', compact('customer', 'listCity', 'seo', 'lang'));
    }
  

    public function shippingStep3(Request $request)
    {
        $status = $request->status ? $request->status : null;
        $cid = (int) $request->cid;
        
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';   
        
        $userId = Session::get('userId');
        // check coi cancel co phai cua user do hay ko ?
        if($cid){
            $rs = Orders::where('customer_id', $userId)->where('id', $cid)->delete();
            if($rs){
                OrderDetail::where('order_id', $cid)->delete();
            }            
        }

        $customer = Customer::find($userId);        

        $getlistProduct = Session::get('products');
            
        if(empty($getlistProduct) || !Session::get('login') || Session::has('new-register')) {
            return redirect()->route('home');
        }
        // check info
        if(!$customer->full_name ||           
           !$customer->address ||
           !$customer->phone ||
           !$customer->country_id ||
           ( $customer->country_id == 235 && (!$customer->district_id ||
           !$customer->city_id ||
           !$customer->ward_id) )
           
        ) {
            Session::flash('update-information', true);
            return redirect()->route('cap-nhat-thong-tin');
        }       


        $listProductId = array_keys($getlistProduct);

        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();         

        $total = $phi_giao_hang = $totalServiceFee = $phi_cod = 0;
        
        foreach($arrProductInfo as $product){
            $price = $product->is_sale ? $product->price_sale : $product->price;                
            $total += $getlistProduct[$product->id]*$price;                            
        }        
        $totalAmount = $total + $totalServiceFee + $phi_giao_hang;        

        $seo = Helper::seo();
        
        return view('frontend.cart.shipping-step-3', compact('arrProductInfo', 'getlistProduct', 'customer', 'phi_giao_hang', 'seo', 'phi_cod', 'totalAmount', 'lang', 'status'));
    }

    public function payment(Request $request){

        $lang = Session::get('locale') ? Session::get('locale') : 'vi';   
        $getlistProduct = Session::get('products');
        $listProductId = array_keys($getlistProduct);
        $customer_id = Session::get('userId');
        $customer = Customer::find($customer_id);
 
        if(empty($listProductId) || !Session::get('login') || Session::has('new-register')) {
            return redirect()->route('home');
        }
  
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();
        $order['tong_tien'] = 0;
        $order['tong_tien_vnd'] = 0;
        $order['tong_sp'] = array_sum($getlistProduct);
        $order['giam_gia'] = 0;
        $order['tien_thanh_toan'] = 0;
        $order['customer_id'] = Session::get('userId') ?  Session::get('userId') : 0;
        $order['status'] = 0;
        $order['coupon_id'] = 0;
        $order['district_id'] = $customer->district_id;
        $order['city_id']  = $customer->city_id;
        $order['ward_id']  = $customer->ward_id;
        $order['address']  = $customer->address;        
        $order['full_name']  = $customer->full_name;
        $order['email']  = $customer->email;
        $order['phone']  = $customer->phone;
        $order['address_type']  = $customer->address_type;
        $order['method_id'] = $request->payment_method;

        // check if ho chi minh free else 150k

        //$order['phi_giao_hang'] = (int) $request->phi_giao_hang;
        $order['phi_giao_hang'] = 0;
        //$order['phi_cod'] = (int) $request->phi_cod;
        $order['phi_cod'] = 0;
        //$order['service_fee'] = Session::get('totalServiceFee') ? Session::get('totalServiceFee') : 0;
        $order['service_fee'] = 0;
        foreach ($arrProductInfo as $product) {
            $price = $product->is_sale ? $product->price_sale : $product->price;        
            $order['tong_tien'] += $price * $getlistProduct[$product->id];
            $order['tong_tien_vnd'] += $product->price_vnd * $getlistProduct[$product->id];
        }

        //$order['tong_tien'] = $order['tien_thanh_toan'] = $order['tong_tien'] + $order['phi_giao_hang'] + $order['service_fee'] + $order['phi_cod'];
        $order['tong_tien'] = $order['tien_thanh_toan'] = $order['tong_tien'] + $order['phi_giao_hang'] + $order['service_fee'] + $order['phi_cod'];
        $city_id = $customer->city_id;
        if( $customer->country_id == 235){
            $order['ngay_giao_du_kien'] = $lang == 'en' ? " from 3 to 5 working days " : " từ 3 đến 5 ngày làm việc ";    
        }else{
            $order['ngay_giao_du_kien'] = $lang == 'en' ? " from 7 to 10 working days " : " từ 7 đến 10 ngày làm việc ";    
        }
        $arrDate = [$order['ngay_giao_du_kien']];

        $getOrder = Orders::create($order);

        $order_id = $getOrder->id;

        Session::put('order_id', $order_id);

        $orderDetail['order_id'] = $order_id;        
       
        foreach ($arrProductInfo as $product) {            
            # code...
            $orderDetail['sp_id']        = $product->id;
            $orderDetail['so_luong']     = $getlistProduct[$product->id];
            $orderDetail['don_gia']      = $product->price;
            $orderDetail['don_gia_vnd']      = $product->price_vnd;
            $orderDetail['tong_tien']    = $getlistProduct[$product->id]*$product->price;
            $orderDetail['tong_tien_vnd']    = $getlistProduct[$product->id]*$product->price_vnd;            
            $orderDetail['so_dich_vu']    =  0;           
            $orderDetail['don_gia_dich_vu']    = 0;            
            $orderDetail['tong_dich_vu']    = 0;
            OrderDetail::create($orderDetail);
            
            $tmpModelProduct = Product::find($product->id);
            $tmpSL = $tmpModelProduct->so_luong_tam > 0 ? $tmpModelProduct->so_luong_tam - 1 : 0;
            $tmpModelProduct->update(['so_luong_tam' => $tmpSL]);
          
        }

        $customer_id = Session::get('userId');
        $customer = Customer::find($customer_id);

        $email = $customer->email;
        
        $emailArr = array_merge([$email], ['hoangnhonline@gmail.com']);
        
        // send email
        $order_id =str_pad($order_id, 6, "0", STR_PAD_LEFT);
        
       
        $SECURE_SECRET = "0C528E5DFBA988E657E1FBFFF5C5DB65";

        // add the start of the vpcURL querystring parameters
        $vpcURL = 'https://payment.napas.com.vn/gateway/vpcpay.do';
        
        $md5HashData = $SECURE_SECRET;
   
        $arrPay['vpc_AccessCode'] = 'D1N2TR3A4DI5NG';
        $arrPay['vpc_Amount'] = ($order['tong_tien_vnd'])."00";
        $arrPay['vpc_BackURL'] = route('shipping-step-3')."?cid=$order_id";
        $arrPay['vpc_Command'] = 'pay';
        $arrPay['vpc_CurrencyCode'] = 'VND';
        $arrPay['vpc_Locale'] = 'vn';
        $arrPay['vpc_MerchTxnRef'] = 'DNO-'.$order_id;
        $arrPay['vpc_Merchant'] = 'DNTRADING';
        $arrPay['vpc_OrderInfo'] = 'DH' .$order_id." " .number_format($order['tong_tien'])." ~ ".number_format($order['tong_tien_vnd']);        
        $arrPay['vpc_ReturnURL'] = route('thanh-cong')."?cid=$order_id";        
        $arrPay['vpc_TicketNo']= $request->ip();
        $arrPay['vpc_Version'] = '2.0';

        // set a parameter to show the first pair in the URL
        $appendAmp = 0;

        foreach($arrPay as $key => $value) {

            // create the md5 input and URL leaving out any fields that have no value
            if (strlen($value) > 0) {
                
                // this ensures the first paramter of the URL is preceded by the '?' char
                if ($appendAmp == 0) {
                    $vpcURL .= '?'.urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;
                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }
                $md5HashData .= $value;
            }
        }
        // Create the secure hash and append it to the Virtual Payment Client Data if
        // the merchant secret has been provided.
        //echo $md5HashData;die;

        if (strlen($SECURE_SECRET) > 0) {
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
        }

        // FINISH TRANSACTION - Redirect the customers using the Digital Order
        // ===================================================================  
      
        return redirect($vpcURL);
        
    }
    public function order(Request $request)
    {
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';   
        $getlistProduct = Session::get('products');
        $listProductId = array_keys($getlistProduct);
        $customer_id = Session::get('userId');
        $customer = Customer::find($customer_id);
  
        if(empty($listProductId) || !Session::get('login') || Session::has('new-register')) {
            return redirect()->route('home');
        }   
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                            ->select('product_img.image_url', 'product.*')->get();
        $order['tong_tien'] = 0;
        $order['tong_tien_vnd'] = 0;
        $order['tong_sp'] = array_sum($getlistProduct);
        $order['giam_gia'] = 0;
        $order['tien_thanh_toan'] = 0;
        $order['customer_id'] = Session::get('userId') ?  Session::get('userId') : 0;
        $order['status'] = 0;
        $order['coupon_id'] = 0;
        $order['district_id'] = $customer->district_id;
        $order['city_id']  = $customer->city_id;
        $order['ward_id']  = $customer->ward_id;
        $order['address']  = $customer->address;        
        $order['full_name']  = $customer->full_name;
        $order['email']  = $customer->email;
        $order['phone']  = $customer->phone;
        $order['address_type']  = $customer->address_type;
        $order['method_id'] = $request->payment_method;
        $order['phi_giao_hang'] = 0;      
        $order['phi_cod'] = 0;       
        $order['service_fee'] = 0;
        foreach ($arrProductInfo as $product) {
            $price = $product->is_sale ? $product->price_sale : $product->price;        
            $order['tong_tien'] += $price * $getlistProduct[$product->id];
            $order['tong_tien_vnd'] += $product->price_vnd * $getlistProduct[$product->id];
        }
      
        $order['tong_tien'] = $order['tien_thanh_toan'] = $order['tong_tien'] + $order['phi_giao_hang'] + $order['service_fee'] + $order['phi_cod'];

        if( $customer->country_id == 235){
            $order['ngay_giao_du_kien'] = $lang == 'en' ? " from 3 to 5 working days " : " từ 3 đến 5 ngày làm việc ";    
        }else{
            $order['ngay_giao_du_kien'] = $lang == 'en' ? " from 7 to 10 working days " : " từ 7 đến 10 ngày làm việc ";    
        }
        $arrDate = [$order['ngay_giao_du_kien']];

        $getOrder = Orders::create($order);

        $order_id = $getOrder->id;

        Session::put('order_id', $order_id);

        $orderDetail['order_id'] = $order_id;
        //$service_fee = Session::get('service_fee');
       
        foreach ($arrProductInfo as $product) {            
            # code...
            $orderDetail['sp_id']        = $product->id;
            $orderDetail['so_luong']     = $getlistProduct[$product->id];
            $orderDetail['don_gia']      = $product->price;
            $orderDetail['don_gia_vnd']      = $product->price_vnd;
            $orderDetail['tong_tien']    = $getlistProduct[$product->id]*$product->price;
            $orderDetail['tong_tien_vnd']    = $getlistProduct[$product->id]*$product->price_vnd;        
            $orderDetail['so_dich_vu']    =  0;            
            $orderDetail['don_gia_dich_vu']    = 0;            
            $orderDetail['tong_dich_vu']    = 0;
            OrderDetail::create($orderDetail); 

            
            $tmpModelProduct = Product::find($product->id);
            $tmpSL = $tmpModelProduct->so_luong_tam > 0 ? $tmpModelProduct->so_luong_tam - 1 : 0;
            $tmpModelProduct->update(['so_luong_tam' => $tmpSL]);
            
        }

        $customer_id = Session::get('userId');
        $customer = Customer::find($customer_id);

        $email = $customer->email;
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $emailAdmin = explode(',', $settingArr['email_nhan_thong_bao']);
        if($email != ""){
            $emailArr = array_merge([$email], $emailAdmin);
        }else{
            $emailArr = $emailAdmin;
        }        
        // send email
        $order_id =str_pad($order_id, 6, "0", STR_PAD_LEFT);
        
        if(!empty($emailArr)){
            Mail::send('frontend.email.cart',
                [
                    'customer'          => $customer,
                    'order'             => $getOrder,
                    'arrProductInfo'    => $arrProductInfo,
                    'getlistProduct'    => $getlistProduct,
                    'arrDate' => $arrDate,                    
                    'method_id' => $order['method_id'],
                    'order_id' => $order_id                    
                ],
                function($message) use ($emailArr, $order_id) {
                    $message->subject('Xác nhận đơn hàng hàng #'.$order_id);
                    $message->to($emailArr);
                    $message->from('web.0917492306@gmail.com', 'TPS.NET.VN');
                    $message->sender('web.0917492306@gmail.com', 'TPS.NET.VN');
            });
        }
        
        return 'success';

    }

    public function success(Request $request){
        $data = $request->all();
        //echo "<pre>";
        //print_r($data);die;
        $lang = Session::get('locale') ? Session::get('locale') : 'vi';   
        // kiem tra coi co san pham ko, ko thi ve home
        $getlistProduct = Session::get('products');        
        
        if(empty($getlistProduct)) {
            return redirect()->route('home');
        }
        // lay thong tin customer
        $customer_id = Session::get('userId');

        $customer = Customer::find($customer_id);
        
        
        if( $customer->country_id == 235){
            $order['ngay_giao_du_kien'] = " từ 3 đến 5 ngày làm việc ";    
        }else{
            $order['ngay_giao_du_kien'] = " từ 7 đến 10 ngày làm việc ";    
        }
        $arrDate = [$order['ngay_giao_du_kien']];

        $order_id = Session::get('order_id');
        $getOrder = Orders::find($order_id);       
        $order_id =str_pad($order_id, 6, "0", STR_PAD_LEFT);
        if(isset($data['vpc_ResponseCode'])){

            if($data['vpc_ResponseCode'] != 0){
                 return redirect()->route('shipping-step-3', ['cid' => $data['cid'], 'status'=> 'error']);
            }else{
                $order_id = $data['cid'];
                $getOrder->da_thanh_toan = 1;
                $getOrder->save();               
                
                $email = $customer->email;        
                $emailArr = array_merge([$email], ['hoangnhonline@gmail.com']);
                if(!empty($emailArr)){

                    $getlistProduct = Session::get('products');
                    $listProductId = array_keys($getlistProduct);
                    $arrProductInfo = Product::whereIn('product.id', $listProductId)
                                        ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id')
                                        ->select('product_img.image_url', 'product.*')->get();

                    Mail::send('frontend.email.cart',
                        [
                            'customer'          => $customer,
                            'order'             => $getOrder,
                            'arrProductInfo'    => $arrProductInfo,
                            'getlistProduct'    => $getlistProduct,
                            'arrDate' => $arrDate,                    
                            'method_id' => $getOrder->method_id,
                            'order_id' => $order_id,
                            'da_thanh_toan' => 1                 
                        ],
                        function($message) use ($emailArr, $order_id) {
                            $message->subject('Xác nhận đơn hàng hàng #'.$order_id);
                            $message->to($emailArr);
                            $message->from('sanphamlamdepcaocap2017@gmail.com', 'sanphamlamdepcaocap.com');
                            $message->sender('sanphamlamdepcaocap2017@gmail.com', 'sanphamlamdepcaocap.com');
                    });
                }
            }
        }
        
        Session::put('products', []);
        Session::put('order_id', '');
        Session::forget('order_id');

        $seo = Helper::seo();

        return view('frontend.cart.success', compact('order_id', 'customer', 'arrDate', 'seo', 'lang'));
    }

    public function deleteAll(){
        Session::put('products', []);
        return redirect()->route('gio-hang');
    }
}

