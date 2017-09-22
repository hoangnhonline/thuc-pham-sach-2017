@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->        
        <!-- ./breadcrumb -->
        <div class="page-content container" style="margin-top:50px">
          <!-- row -->
          <div class="cart-page row">

            <!-- Center colunm-->
            <div class="col-lg-8 col-md-12 cart-col-1">

                <div class="row title visible-md-block visible-lg-block">
                    <div class="col-lg-9 col-md-9">
                        <h5>{{ trans('text.san-pham-trong-gio-hang') }}</h5>
                        <span class="badge">{{ array_sum($getlistProduct) }}</span>
                    </div>
                    <div class="col-lg-1 col-md-1"><h6>{{ trans('text.gia') }}</h6></div>
                    <div class="col-lg-1 col-md-1"><h6>{{ trans('text.so-luong') }}</h6></div>      
                    <div class="col-lg-1 col-md-1 end"><h6>{{ trans('text.thanh-tien') }}</h6></div>
                </div>
                <?php
                  $total = $total_vnd = 0;
                ?>

                <form id="shopping-cart" method="POST" action="{{ route('shipping-step-1') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  @if( $arrProductInfo->count() > 0)
                  @foreach($arrProductInfo as $product)
                  
                  <?php $price = $product->is_sale ? $product->price_sale : $product->price; ?>
                  <div class="row shopping-cart-item">
                    <div class="col-lg-3 col-md-2 col-xs-3">
                      <p class="image">
                      <!-- <span class="sale">-47%</span>  -->
                      <img class="img-responsive lazy" data-original="{{ Helper::showImage($product['image_url']) }}">
                      </p>
                    </div>
                    <div class="col-lg-6 col-md-6 c2 col-xs-9">
                      <p class="name">
                      <a href="" target="_blank">{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}</a>
                      </p>
                      <div class="row visible-xs-block visible-sm-block">
                        <div class="col-xs-6 col-sm-8">
                          
                          
                          @if($lang == 'en')
                          <p class="price">{{ number_format($price) }}$</p>
                          <p class="price">{{ number_format($product->price_vnd) }} VND</p>
                          @else
                          <p class="price">{{ number_format($product->price_vnd) }}</p>
                          @endif

                        </div>
                        <div class="col-xs-6 col-sm-4 cart-col-3 quantity-block">
                           <select data-product-id="{{$product->id}}" class="form-control js-quantity-select quantity js-quantity-product">
                            @for($i = 1; $i <= 50; $i++ )
                            <option value="{{$i}}"
                            @if ($i == $getlistProduct[$product->id])
                              selected
                            @endif
                            > {{$i}}
                              @if($i == 50) + @endif
                            </option>
                            @endfor
                          </select>
                        </div>
                      </div>
                      <p class="action">
                        <a class="btn btn-link btn-item-delete" data-product-id="{{ $product->id }}"> {{ trans('text.xoa') }} </a>                        
                      </p>
                    </div>
                    <div class="col-lg-1 col-md-1 visible-md-block visible-lg-block">
                      
                      
                      
                      @if($lang == 'en')
                      <p class="price">{{number_format($price)}}$</p>
                      <p class="price">{{ number_format($product->price_vnd) }} đ</p>
                      @else
                      <p class="price">{{ number_format($product->price_vnd) }}</p>
                      @endif


                    </div>
                    <div class="col-lg-1 col-md-1 visible-md-block visible-lg-block quantity-block">
                      <!-- If product qty < 10, show select options -->
                      <select data-product-id="{{$product->id}}" class="form-control js-quantity-select quantity js-quantity-product">
                        @for($i = 1; $i <= 50; $i++ )
                        <option value="{{$i}}"
                        @if ($i == $getlistProduct[$product->id])
                          selected
                        @endif
                        > {{$i}}
                          @if($i == 50) + @endif
                        </option>
                        @endfor
                      </select>
                    </div>                   
                    <div class="col-lg-1 col-md-1 visible-md-block visible-lg-block end">
                      
                      @if($lang == 'en')
                      <p class="price3">{{number_format($getlistProduct[$product->id]*$price)}}$</p>
                      <p class="price3">{{number_format($getlistProduct[$product->id]*$product->price_vnd)}} đ</p>                      
                      @else
                      <p class="price3">{{number_format($getlistProduct[$product->id]*$product->price_vnd)}}</p>                      
                      @endif
                    </div>
                  </div><!-- end /.shopping-cart-item -->
                  <?php $total += $getlistProduct[$product->id]*($price); 
                  $total_vnd += $getlistProduct[$product->id]*($product->price_vnd);
                  ?>
                  @endforeach
                  @else
                  <p style="text-align:center;margin:15px">Chưa có sản phẩm nào trong giỏ hàng của bạn.</p>
                  @endif
                </form>

                <div class="row last" style="margin-top:10px">
                    <div class="col-lg-12 col-md-12">
                        <div class="all-new">
                            <a class="btn btn-default btn-gradient" href="{{ route('home') }}" style="margin-bottom:2px"><i class="fa fa-angle-left"></i> {{ trans('text.tiep-tuc-mua-sam') }}</a>
                            @if(!empty(Session::get('products')))
                            <a class="btn btn-default btn-gradient" style="margin-bottom:2px" onclick="return confirm('Xóa tất cả sản phẩm trong giỏ hàng?');" href="{{ route('xoa-gio-hang') }}"><i class="fa fa-trash-o"></i> {{ trans('text.xoa-toan-bo') }}</a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <!-- ./ Center colunm -->

            <!-- Left colunm -->
            <div class="col-lg-4 col-md-12 cart-col-2">
                <div id="right-affix" class="affix-top">
                  <div class="visible-lg-block">
                    <div class="panel panel-default fee">
                      <div class="panel-body">
                        
                        @if($lang == 'en')
                        <p class="total">{{ trans('text.tong-cong') }}: <span>{{ number_format($total) }}$</span></p>
                        <p class="total">{{ trans('text.thanh-tien') }}: <span>{{ number_format($total) }}$ </span></p>
                        <p class="total">{{ trans('text.thanh-tien') }} VND: <span>{{ number_format($total_vnd) }}$ </span></p>
                        @else
                        <p class="total">{{ trans('text.thanh-tien') }}: <span>{{ number_format($total_vnd) }} </span></p>
                        @endif
                        @if($total > 0)
                        <p class="text-right"> <i>({{ trans('text.da-bao-gom-vat') }})</i> </p>
                        @endif
                      </div>
                    </div>
                   @if( $arrProductInfo->count() > 0)                    
                    
                    <button type="button" class="btn btn-large btn-block btn-default btn-checkout"> {{ trans('text.dat-hang') }} </button>
                    @endif                    
                  </div>
                  <div class="visible-xs-block">
                    <div class="panel panel-default fee">
                      <div class="panel-body">
                        <p class="total">{{ trans('text.tong-cong') }}: <span>{{ number_format($total) }}$</span></p>
                        <p class="total">{{ trans('text.thanh-tien') }}: <span>{{ number_format($total) }}$ </span></p>
                        @if( $total > 0)  
                        <p class="text-right"> <i>({{ trans('text.da-bao-gom-vat') }})</i> </p>
                        @endif
                      </div>
                    </div>
                  </div>
                  @if( $arrProductInfo->count() > 0)
                  <div class="visible-xs-block">
                    <button type="button" class="btn btn-large btn-block btn-default btn-checkout"> {{ trans('text.dat-hang') }} </button>
                  </div>
                  @endif
                </div>
            </div>
            <!-- ./left colunm -->
        </div><!-- ./row-->
        </div><!-- /.page-content -->
    </div>
</div>
<style type="text/css">
  .checkbox-inline, .radio-inline{
    padding-left: 0px !important;
  }
</style>
@endsection
@section('javascript')
   <script type="text/javascript">
    $(document).ready(function() {
      $('#add_service').on('ifChecked', function(event){
          setServicesFee(1);
      });
      $('#add_service').on('ifUnchecked', function(event){
          setServicesFee(0);
      });
      $('.btn-checkout').click(function() {
        $('form#shopping-cart').submit();
        //location.href = "{{ route('shipping-step-1') }}";
      });

      $('.js-quantity-product').change(function() {
        var quantity = $(this).val();
        var id = $(this).attr('data-product-id');
        update_product_quantity(id, quantity);
      });

      $('.btn-item-delete').click(function() {
        var id = $(this).attr('data-product-id');
        update_product_quantity(id, 0);
      });


      
      function update_product_quantity(id, quantity) {
        $.ajax({
          url: "{{route('update-sanpham')}}",
          method: "POST",
          data : {
            id: id,
            quantity : quantity
          },
          success : function(data){
            location.reload();
          },
          error : function(e) {
            alert( JSON.stringify(e));
          }
        });
      }
    })
  </script>
@endsection








