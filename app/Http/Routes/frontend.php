<?php
Route::group(['prefix' => 'social-auth'], function () {
    Route::group(['prefix' => 'facebook'], function () {
        Route::get('redirect/', ['as' => 'fb-auth', 'uses' => 'SocialAuthController@redirect']);
        Route::get('callback/', ['as' => 'fb-callback', 'uses' => 'SocialAuthController@callback']);
        Route::post('fb-login', ['as' => 'ajax-login-by-fb', 'uses' => 'SocialAuthController@fbLogin']);
    });

    Route::group(['prefix' => 'google'], function () {
        Route::get('redirect/', ['as' => 'gg-auth', 'uses' => 'SocialAuthController@googleRedirect']);
        Route::get('callback/', ['as' => 'gg-callback', 'uses' => 'SocialAuthController@googleCallback']);
    });

});

Route::group(['prefix' => 'authentication'], function () {
    Route::post('check_login', ['as' => 'auth-login', 'uses' => 'AuthenticationController@checkLogin']);
    Route::post('login_ajax', ['as' =>  'auth-login-ajax', 'uses' => 'AuthenticationController@checkLoginAjax']);
    Route::get('/user-logout', ['as' => 'user-logout', 'uses' => 'AuthenticationController@logout']);
});

Route::group(['namespace' => 'Frontend'], function()
{
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/lang/set-lang', ['as' => 'set-lang', 'uses' => 'HomeController@setLang']);
     Route::post('/dang-ki-newsletter', ['as' => 'register.newsletter', 'uses' => 'HomeController@registerNews']);
    Route::get('/cap-nhat-thong-tin', ['as' => 'cap-nhat-thong-tin', 'uses' => 'CartController@updateUserInformation']);
    Route::get('/{slug}', ['as' => 'danh-muc-cha', 'uses' => 'CateController@index']);
    Route::post('/send-contact', ['as' => 'send-contact', 'uses' => 'ContactController@store']);
    Route::post('/set-service', ['as' => 'set-service', 'uses' => 'CartController@setService']);    
    
    Route::get('chi-tiet/{slug}-{id}.html', ['as' => 'chi-tiet-vi', 'uses' => 'DetailController@index']);
    Route::get('detail/{slug}-{id}.html', ['as' => 'chi-tiet-en', 'uses' => 'DetailController@index']);
    Route::get('tag/{slug}', ['as' => 'tag', 'uses' => 'OtherController@tag']);

    Route::get('album/{slug}-{id}.html', ['as' => 'chi-tiet-album', 'uses' => 'AlbumController@detail']);
    Route::get('bo-suu-tap.html', ['as' => 'album-vi', 'uses' => 'AlbumController@index']);
    Route::get('collection.html', ['as' => 'album-en', 'uses' => 'AlbumController@index']);

    Route::get('video/{slug}-{id}.html', ['as' => 'video-detail', 'uses' => 'VideoController@detail']);
    Route::get('video.html', ['as' => 'video', 'uses' => 'VideoController@index']);

    Route::get('tin-tuc/{slug}-{id}.html', ['as' => 'news-detail-vi', 'uses' => 'NewsController@detail']);
    Route::get('news/{slug}-{id}.html', ['as' => 'news-detail-en', 'uses' => 'NewsController@detail']);

    Route::get('news.html', ['as' => 'news-en', 'uses' => 'NewsController@index']);
    Route::get('tin-tuc.html', ['as' => 'news-vi', 'uses' => 'NewsController@index']);

    Route::group(['prefix' => 'thanh-toan'], function () {
        Route::get('gio-hang', ['as' => 'gio-hang', 'uses' => 'CartController@index']);
        Route::get('xoa-gio-hang', ['as' => 'xoa-gio-hang', 'uses' => 'CartController@deleteAll']);
        Route::any('shipping-step-1', ['as' => 'shipping-step-1', 'uses' => 'CartController@shippingStep1']);
        Route::get('shipping-step-2', ['as' => 'shipping-step-2', 'uses' => 'CartController@shippingStep2']);
        Route::get('shipping-step-3', ['as' => 'shipping-step-3', 'uses' => 'CartController@shippingStep3']);
        Route::post('update-sanpham', ['as' => 'update-sanpham', 'uses' => 'CartController@update']);
        Route::post('them-sanpham', ['as' => 'them-sanpham', 'uses' => 'CartController@addProduct']);
        Route::get('thanh-cong', ['as' => 'thanh-cong', 'uses' => 'CartController@success']);
        Route::post('dat-hang', ['as' => 'dat-hang', 'uses' => 'CartController@order']);  
        Route::post('payment', ['as' => 'payment', 'uses' => 'CartController@payment']);  
              
    });
     Route::group(['prefix' => 'tai-khoan'], function () {
        Route::get('don-hang-cua-toi', ['as' => 'order-history', 'uses' => 'OrderController@history']);
        Route::get('thong-bao-cua-toi', ['as' => 'notification', 'uses' => 'CustomerController@notification']);
        Route::get('thong-tin-tai-khoan', ['as' => 'account-info', 'uses' => 'CustomerController@accountInfo']);
        Route::get('doi-mat-khau', ['as' => 'change-password', 'uses' => 'CustomerController@changePassword']);
        Route::post('save-new-password', ['as' => 'save-new-password', 'uses' => 'CustomerController@saveNewPassword']);
        Route::get('/chi-tiet-don-hang/{order_id}', ['as' => 'order-detail', 'uses' => 'OrderController@detail']);
        Route::post('/huy-don-hang', ['as' => 'order-cancel', 'uses' => 'OrderController@huy']);
        Route::post('/forget-password', ['as' => 'forget-password', 'uses' => 'CustomerController@forgetPassword']);
        Route::get('/reset-password/{key}', ['as' => 'reset-password', 'uses' => 'CustomerController@resetPassword']);
        Route::post('save-reset-password', ['as' => 'save-reset-password', 'uses' => 'CustomerController@saveResetPassword']);
   
    });
    Route::get('{slugLoaiSp}/{slug}/', ['as' => 'danh-muc-con', 'uses' => 'CateController@cate']);    
    
    Route::get('/tim-kiem.html', ['as' => 'search', 'uses' => 'HomeController@search']);   
    Route::get('contact.html', ['as' => 'contact-en', 'uses' => 'HomeController@contact']);
    Route::get('lien-he.html', ['as' => 'contact-vi', 'uses' => 'HomeController@contact']);
    Route::get('{slug}.html', ['as' => 'pages', 'uses' => 'PageController@index']);

    

   
    Route::post('/get-district', ['as' => 'get-district', 'uses' => 'DistrictController@getDistrict']);
    Route::post('/get-ward', ['as' => 'get-ward', 'uses' => 'WardController@getWard']);
    Route::post('/customer/update', ['as' => 'update-customer', 'uses' => 'CustomerController@update']);
    Route::post('/customer/register', ['as' => 'register-customer', 'uses' => 'CustomerController@register']);
    Route::post('/customer/register-ajax', ['as' => 'register-customer-ajax', 'uses' => 'CustomerController@registerAjax']);
    Route::post('/customer/checkemail', ['as' => 'checkemail-customer', 'uses' => 'CustomerController@isEmailExist']);    
});