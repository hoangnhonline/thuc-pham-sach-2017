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
                            <h2 style="text-transform:none !important">Tìm kiếm theo từ khóa <span style="color:#28AA4A">'{{ $tu_khoa }}'</span></h2>                          
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
                                    @else
                                    <li style="padding-left:20px">{{ $lang  == 'vi' ? "Không tìm thấy sản phẩm nào." : "Not found data."}}</li>
                                    @endif
                                </ul>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="sort-pagi-bar">
                                            {{ $productArr->appends( ['keyword' => $tu_khoa] )->links() }}      
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
            @include('frontend.pages.sidebar')
            
        </div>
    </div>
</div>

@endsection