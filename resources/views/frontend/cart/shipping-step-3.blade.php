@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <div class="page-content">
          <!-- row -->
          <div class="shipping-address-page">             

                <div class="row visible-lg-block">
                  <div class="col-lg-12">
                    <h3 style="font-size:15px">3. {{ trans('text.thanh-toan-va-dat-mua') }}</h3>
                  </div>
                </div>

                <div class="row row-style-2">
                  <div class="col-md-8 has-padding">
                  @if($status == 'error')
                        <div class="alert alert-danger fade in alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            Quý khách vui lòng thực hiện thanh toán lại hoặc chọn hình thức thanh toán khác.
                        </div>
                        @endif
                    <div class="panel panel-default payment">
                      <div class="panel-body">

                        <form class="form-horizontal hide-block" role="form" id="form-payment" action="{{ route('payment') }}" method="post">
                          {{ csrf_field() }}                        
                          <div class="form-group row">
                            <h4 class="col-lg-12 is-mt">{{ trans('text.chon-hinh-thuc-thanh-toan') }}: </h4>
                          </div>
                          <ul class="wc_payment_methods payment_methods methods">
                          <li class="wc_payment_method payment_method_bacs" style="margin-bottom:15px">
                             <input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="1"  checked="checked">
                             <label for="payment_method_bacs">
                             Giao hàng thu tiền tận nhà ( COD )     </label>
                             
                          </li>         
                          
                          <li class="wc_payment_method payment_method_bacs">
                             <input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="2" >
                             <label for="payment_method_bacs">
                             Chuyển khoản ngân hàng     </label>
                             <div class="payment_box payment_method_bacs" >
                                <div class="box-info-payment">
                                   <div class="info-payment-top">
                                      Quý khách có thể lựa chọn chuyển khoản tới 1 trong những ngân hàng sau:
                                   </div>
                                   <div class="info-payment-center">
                                      <ul>
                                         <li class="info-payment-item">
                                            <div class="payment-thumb">
                                               <img src="http://vshop24.com/images/acb_logo.png">
                                            </div>
                                            <div class="payment-detail">
                                               <div class="payment-bankname">Ngân Hàng Thương Mại Cổ Phần Á Châu - Chi Nhánh Thủ Đức</div>
                                               <div class="payment-detail-row">                                                 
                                                  <div class="detail-row row-name"><b>Chủ tài khoản:</b> <span class="row-txt">Chi Nhánh Thủ Đức - Công ty cổ phần IPL</span></div>
                                                  <div class="detail-row row-number"><b>Số TK:</b> <span class="row-txt">82901409</span></div>
                                               </div>
                                            </div>
                                         </li>
                                      </ul>
                                   </div>
                                </div>
                             </div>
                          </li>
                           
                                                    
                          </ul>
                          
                          <div id="bookcare-option"> </div>
                          <div class="form-group row end">
                            <div class="col-lg-6">
                              <button type="button" id="btn-placeorder" class="btn btn-block btn-default btn-checkout">{{ trans('text.dat-mua') }}</button>
                              <button type="button" class="btn btn-default" id="btnLoading" style="display:none;margin-left:15px"><i class="fa fa-spin fa-spinner"></i></button>
                              <p class="note">Bạn vui lòng kiểm tra lại đơn hàng trước khi Đặt Mua</p>
                            </div>
                          </div>
                          <input type="hidden" name="phi_giao_hang" value="0">
                          <input type="hidden" name="phi_cod" id="phi_cod" value="0">
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="panel panel-default cart">
                      <div class="panel-body">
                        <div class="order"> <span class="title"> {{ trans('text.dia-chi-giao-hang') }} </span> <a href="{{route('shipping-step-2')}}" class="btn btn-default btn-custom1">{{ trans('text.sua') }}</a> </div>
                        <div class="information">
                          
                          <h6>{{ $customer->full_name }}</h6>
                          <p class="end">
                            @if($customer->country_id == 235)
                              @if( isset( $customer->tinh->name ))
                                {{ $customer->tinh->name }},
                              @endif
                              @if( isset( $customer->huyen->name ) )
                                {{ $customer->huyen->name }},
                              @endif
                              @if( isset($customer->xa->name ))
                                {{ $customer->xa->name }},
                              @endif
                              @else
                                @if( isset($customer->country->name ))
                                  {{ $customer->country->name }},
                                @endif
                              @endif
                            {{ $customer->address }}<br>
                            {{ trans('text.dien-thoai') }}: {{ $customer->phone }}<br>
                            </p>
                       
                        </div>
                      </div>
                    </div>
                    @include('frontend.cart.blocks.panel-cart')

                  </div>
                </div>

           </div><!-- /.shipping-address-page -->

        </div><!-- /.page-content -->
    </div>
</div>
@endsection
@section('javascript')
   <script type="text/javascript">
    $(document).ready(function() {
      $('.btn-checkout').click(function(){
        $(this).attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i> Đang xử lý...');        
        var payment_method = $('input[name=payment_method]:checked').val();
        var url = '';
        if(payment_method == 3){
          $('#form-payment').submit();
        }else{
          $.ajax({
            url: "{{ route('dat-hang') }}",
            method: "POST",
            data : {
              payment_method : payment_method,
              phi_giao_hang : 0,
              phi_cod : $('#phi_cod').val()
            },
            success : function(data){            
              location.href = "{{ route('thanh-cong') }}";
            }
          });
        }
        
      });     
    })
  </script>
@endsection