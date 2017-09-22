<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Customer;
use Session;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkLogin(Request $request)
    {
        $dataArr = $request->all();

        $this->validate($request,[
            'phone' => 'required',
            'password' => 'required'
        ],
        [
            'phone.required' => 'Bạn chưa nhập số ĐT',
            'password.required' => 'Bạn chưa nhập mật khẩu'
        ]);

        $dataArr = [
            'phone' => $request->phone,
            'password' => $request->password,
        ];

        $customer = Customer::where('phone', $request->phone)->first();
        if(is_null($customer) || !password_verify($request->password, $customer->password) ) {
            Session::flash('error', 'Email hoặc mật khẩu không đúng.');
        } else {
            Session::put('login', true);
            Session::put('userId', $customer->id);
            Session::put('facebook_id', $customer->facebook_id);
            Session::put('username', $customer->full_name);
            Session::put('avatar', $customer->image_url);
            Session::forget('vanglai');
            Session::forget('is_vanglai');
        }
        return redirect()->back();
    }

    public function checkLoginAjax(Request $request)
    {
        $dataArr = $request->all();

        $customer = Customer::where('phone', $request->phone)->first();
        if(is_null($customer) || !password_verify($request->password, $customer->password) ) {
            Session::flash('error', 'Số ĐT hoặc mật khẩu không đúng.');
            return response()->json(['error' => 1]);
        } else {
            Session::put('login', true);
            Session::put('userId', $customer->id);
            Session::put('facebook_id', $customer->facebook_id);
            Session::put('username', $customer->full_name);
            Session::put('avatar', $customer->image_url);
            return response()->json(['error' => 0]);
            Session::forget('vanglai');
            Session::forget('is_vanglai');
        }
    }

    public function logout(Request $request)
    {
        Session::forget('login');
        Session::forget('userId');
        Session::forget('username');
        Session::forget('avatar');
        Session::forget('facebook_id');
        Session::forget('vanglai');
        Session::put('products', []);
        Session::put('order_id', '');
        Session::forget('is_vanglai');        
        Session::forget('service_fee');
        Session::forget('totalServiceFee');
        Session::forget('event_id');
        Session::forget('order_id');
        Session::forget('new-register');
        return redirect()->route('home');
    }
}
