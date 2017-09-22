@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="columns-container">
    <div class="container" id="columns">
                    
        <div class="page-content" style="margin-top:50px">
          <!-- row -->
          <div class="shipping-address-page">
              
                <div class="row row-style-5">
                  <div class="col-lg-8">
                    <div class="panel panel-default success">
                      <div class="panel-body">
                        <div class="row row-style-6">
                          <div class="col-lg-4 col-md-3 visible-lg-block visible-md-block"> 
                          <img src="{{ URL::asset('public/assets/images/thanh-cong.png') }}" class="img-responsive" alt="Image" height="178" width="195"></div>
                          <div class="col-lg-8 col-md-9">
                            <h3>Cảm ơn bạn đã mua hàng tại TPS</h3>
                            
                            <!-- BEGIN ORDER INFO -->
                            <p>Mã số đơn hàng của bạn: </p>
                            <div class="well well-sm"> {{ $order_id }} </div>                            
                            <p>Bạn có thể xem lại <a href="{{ route('order-history') }}">đơn hàng của tôi</a></p>
                            <p> <img src="{{ URL::asset('public/assets/images/info.png') }}" alt="thong tin" width="30"> Thời gian dự kiến giao hàng : {{ $arrDate[0] }} </p><br>
                            @if((isset($customer) && $customer->email != ''))
                            <p> Thông tin chi tiết về đơn hàng đã được gửi đến địa chỉ mail <span>{{ $customer->email }}</span>. Nếu
                              không tìm thấy vui lòng kiểm tra trong hộp thư <strong>Spam</strong> hoặc <strong>Junk Folder</strong>. </p>
                              @endif
                              <br>                                                         
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 visible-lg-block">
                    <h3 class="news"></h3>
                    <div class="popover bottom newsletter">
                      <div class="arrow"></div>
                      <div class="popover-content">
                        <h6>Nhập địa chỉ email của bạn</h6>
                        
                          <input type="email" id="reg_success" class="form-control" value="" required="required" type="text">
                          <button type="button" class="btn btn-primary btn-block" id="btnRegTin">Đăng ký nhận tin khuyến mãi</button>
                        
                      </div>
                    </div>
                    <div class="facebook-page"> </div>
                  </div>
                </div>
                
           </div><!-- /.shipping-address-page -->   
                           
        </div><!-- /.page-content -->
    </div>
</div>
@endsection