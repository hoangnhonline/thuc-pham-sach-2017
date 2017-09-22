@extends('frontend.layout')
@include('frontend.partials.meta')

@section('content')
<div class="content-shop left-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12 main-content">
                <div class="main-content-shop">                 
                    <h2 class="page-heading">
                        <span class="page-heading-title2">{{ trans('text.don-hang') }} #{{ $str_order_id }} - {{ $status[$order->status] }}</span>
                    </h2>
                    <!-- Content page -->
                      
                      <div class="account-order-detail">
                      
                        <p class="date mt10 mb20">{{ trans('text.ngay-mua') }}:  {{ $ngay_dat_hang }}</p>
                        
                        <div class="address-1">
                          <h4 class="mb20"> {{ trans('text.dia-chi') }} </h4>
                          <p style="font-weight:bold">{{ $customer->full_name }}</p>
                          <p>{{ $customer->address }}, 
                          @if(isset($customer->xa->name))
                            {{$customer->xa->name}}
                          @endif, 
                          @if(isset($customer->huyen->name))
                            {{$customer->huyen->name}},
                          @endif
                          @if(isset($customer->tinh->name))
                            {{$customer->tinh->name}}
                          @endif</p>
                          <p>{{ trans('text.dien-thoai') }}: {{ $customer->phone }}</p>
                        </div>
                        
                        <div class="row mb20 mt20">
                          <div class="col-sm-7">
                            <div class="payment-1">
                              <h4 class="mb20">{{ trans('text.phuong-thuc-van-chuyen') }}</h4>
                              <p>Vận chuyển Tiết Kiệm (dự kiến giao hàng vào {{ $order->ngay_giao_du_kien }})</p>
                              
                            </div>

                          </div>
                          <div class="col-sm-5">
                            <div class="payment-2 has-padding">
                              <h4 class="mb20">{{ trans('text.hinh-thuc-thanh-toan') }}</h4>
                              <p>@if($order->method_id == 1)
                              Chuyển khoản ngân hàng
                              @elseif($order->method_id == 2)
                              INTERNET BANKING / VISA / MASTER CARD
                              @endif
                              <?php
                              echo "<br/>";
                              if($order->da_thanh_toan == 1){
                                echo " <span style='color:red'>ĐÃ THANH TOÁN</span>";
                              }else{
                                echo " <span style='color:red'>CHƯA THANH TOÁN</span>";
                              }
                              ?>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <h4 class="mb10">{{ trans('text.san-pham') }}</h4>
                      
                      <div class="table-responsive">
                        <table class="table table-bordered dashboard-order">
                          <thead>
                            <tr class="default">
                              <th class="text-nowrap"> <span class="hidden-xs hidden-sm hidden-md">{{ trans('text.ten-san-pham') }}</span> <span class="hidden-lg">{{ trans('text.san-pham') }}</span> </th>                           
                              <th class="text-nowrap">{{ trans('text.gia') }}</th>
                              <th class="text-nowrap">{{ trans('text.so-luong') }}</th>                          
                              <th class="text-nowrap">{{ trans('text.tong-cong') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($orderDetail as $rowOrder)
                            <tr>
                              <td><a href="#" target="_blank" class="link">{{ Helper::getName($rowOrder->sp_id, "product" ) }}</a> </td>
                             
                              <td><strong class="hidden-lg hidden-md">{{ trans('text.gia') }}: </strong>{{ number_format($rowOrder->don_gia_vnd) }}</td>
                              <td><strong class="hidden-lg hidden-md">{{ trans('text.so-luong') }}: </strong>{{ $rowOrder['so_luong'] }} </td>
                             
                              <td><strong class="hidden-lg hidden-md">{{ trans('text.tong-cong') }}: </strong>{{ number_format($rowOrder->tong_tien_vnd) }}</td>
                            </tr>
                            @endforeach                         
                          </tbody>
                          <tfoot>                                                                            
                            <tr>
                              <td colspan="3" class="text-right"><strong>{{ trans('text.tong-tien') }}</strong></td>
                              <td><strong>{{ number_format($order->tong_tien_vnd)}}</strong></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>                    
                      <a href="{{ route('order-history')}}" class="btn btn-info btn-back"><i class="fa fa-caret-left"></i> {{ trans('text.quay-ve') }} {{ trans('text.don-hang-cua-toi') }}</a>
                      @if($order->status == 0)
                      <button id="btnHuy" class="btn btn-danger" style="float:right"><i class="fa fa-times"></i> {{ trans('text.huy') }} {{ trans('text.don-hang') }}</button>
                      @endif
                </div>
                <!-- End Main Content Shop -->
            </div>
            @include('frontend.account.sidebar')
            
        </div>
    </div>
</div>

<div class="clearfix"></div>
@endsection
@section('javascript')
   <script type="text/javascript">
    $(document).ready(function() {
      $('#btnHuy').click(function(){ 
        var obj = $(this);       
        if(confirm('{{ trans('text.chac-chan-huy-don-hang') }}?')){
          $.ajax({
            url : '{{ route('order-cancel') }}',
            type  : 'POST',
            data : {
              id : {{ $order->id }}
            },
            success : function(){
              swal({ title: '', text: '{{ trans('text.da-huy-don-hang') }} #{{ $str_order_id }}', type: 'success' });
              obj.remove();
            }
          });
        }
      });
    });
  </script>
@endsection