@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="content-shop left-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12 main-content">
                <div class="main-content-shop">                 
                    <!-- End Banner Slider -->                  
                    <!-- End List Shop Cat -->
                    <div class="shop-tab-product">
                        <div class="shop-tab-title">
                            <h2>{{ $lang == 'vi' ? $rsCate->name_vi : $rsCate->name_en }}</h2>                          
                        </div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="product-grid">
                                <ul class="row product-grid auto-clear">
                                    @if($productArr->count() > 0)
                                    @foreach($productArr as $product)
                                    <li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="item-product">
                                            <div class="product-thumb">
                                                <a class="product-thumb-link" href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->id]) }}">
                                                    <img class="first-thumb" src="{{ Helper::showImage($product->image_url) }}" alt="{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}" >
                                                     <img class="second-thumb" src="{{ Helper::showImage($product->image_url) }}" alt="{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}" >
                                                </a>
                                                @if($product->price > 0 || $product->price_vnd > 0)
                                                <div class="product-info-cart">                                                 
                                                    <a class="{{ $product->het_hang == 1 ? "het-hang" : 'addcart-link' }}" href="javascript:void(0)" data-id="{{ $product->id }}">@if($product->het_hang == 0) <i class="fa fa-shopping-basket"></i>@endif {{ $product->het_hang == 1 ? "Tạm hết hàng" : trans('text.mua-hang') }}</a>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="product-info product-info5">
                                                <h3 class="title-product"><a href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->id]) }}">{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}</a></h3>
                                                <div class="info-price">
                                                    @if($product->het_hang == 0)
                                                    @if($product->is_sale == 1 && $product->price_sale > 0)
                                                      <span>{{ number_format($product->price_sale) }}$</span>
                                                      <del>{{ number_format($product->price) }}$</del>
                                                    @else
                                                      @if($lang == 'en' && $product->price_vnd > 0)
                                                      <span>{{ $product->price > 0 ? number_format($product->price)."$" : "Liên hệ" }}</span><br>
                                                      <span>{{ $product->price_vnd > 0 ? number_format($product->price_vnd)." VND" : "Liên hệ" }}</span>
                                                      @else
                                                      <span>{{ $product->price_vnd > 0 ? number_format($product->price_vnd) : "Liên hệ" }}</span>
                                                      @endif
                                                    @endif 
                                                    @else
                                                    <span class="het-hang">Tạm hết hàng</span>
                                                    @endif  
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="sort-pagi-bar">
                                            {{ $productArr->appends( ['mid' => $mid, 'pf' => $p_from, 'pt' => $p_to, 'ip' => $ip, 's' => $s] )->links() }}      
                                        </div>
                                    </div>
                                </div>
                                <!-- End Sort Pagibar -->
                            </div>                          
                        </div>
                    </div>
                    <!-- End Shop Tab -->
                </div>
                <!-- End Main Content Shop -->
            </div>
            @include('frontend.detail.sidebar')
            
        </div>
    </div>
</div>
<form method="GET" action="{{ url()->current() }}" id="formSeach">
    <input type="hidden" name="pf" id="pf" value="{{ $p_from }}">
    <input type="hidden" name="pt" id="pt" value="{{ $p_to }}">      
    <input type="hidden" name="ip" id="ip" value="{{ $ip }}">
    <input type="hidden" name="s" id="s" value="{{ $s }}">            
</form>
@endsection
@section('javascript')
<script type="text/javascript">
(function($) {
    var url = '{{ url()->current() }}';
    "use strict";            
    /*  [ Filter by price ] */
    $('#slider-range').slider({
        range: true,
        min: 0,
        max: {{ $maxPrice }},
        values: [{{ $p_from }}, {{ $p_to }}],
        step : 5,
        slide: function (event, ui) {
            $('#amount-left').text(number_format(ui.values[0], 0, '.', '.') + ' $');
            $('#amount-right').text(number_format(ui.values[1], 0, '.', '.') + ' $');

        },
        change : function(event, ui){
            $('#pf').val(ui.values[0]);
            $('#pt').val(ui.values[1]);
            $('#formSeach').submit();
        }
    });
    $('#amount-left').text( number_format($('#slider-range').slider('values', 0), 0, '.', '.')  + ' $');
    $('#amount-right').text( number_format($('#slider-range').slider('values', 1), 0, '.', '.')  + ' $');

})(jQuery);
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
</script>
@endsection