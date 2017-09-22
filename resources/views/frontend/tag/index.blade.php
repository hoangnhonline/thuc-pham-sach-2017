@extends('frontend.layout')

@section('content')

        
        <div class="block-headline-detail container">
            <ul class="breadcrumb breadcrumb-customize">
                <li><a href="{{ route('home') }}">{{ trans('text.home') }}</a></li>                
                <li><a href="javascript:;">Tag</a></li>
                <li>
                    <a href="{{ route('tag', [$rs->slug]) }}">{{ $rs->name }}</a>
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="row">                
                @include('frontend.detail.sidebar')
                <div class="block-main col-lg-9 col-md-8 col-sm-8">
                    <div class="product-view">

                        <div class="title-page">
                            <h1 class="page-title">Tag : {{ $rs->name }}</h1>
                        </div>

                        <div class="clearfix"></div>                                         
                        <div class="box-product row">
                            @if($productArr->count() > 0)
                            @foreach($productArr as $product)
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="products-item">
                                    <div class="products-img">
                                      <a href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->id]) }}">
                                        <img src="{{ Helper::showImage($product->image_url) }}" alt="{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}">
                                      </a>
                                    </div>
                                    <div class="products-info">
                                      <h2 class="products-info-name">
                                        <a class="ten_sp " title="{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}" href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->id]) }}">{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}</a>
                                      </h2>
                                      <p class="products-info-price">
                                        @if($product->is_sale == 1 && $product->price_sale > 0)
                                          <span class="price-new">{{ number_format($product->price_sale) }}</span>
                                          <del class="price-old">{{ number_format($product->price) }}</del>
                                        @else
                                          <span class="price-new">{{ number_format($product->price) }}</span>
                                        @endif
                                      </p>
                                      <div class="wishlist-compare">
                                        <div class="wishlist"><a href="#" class="wishlist-ss"><i class="icofont icofont-info-square"></i></a></div>
                                        <div class="compare"><span href="#" class="check-ss"></span></div>
                                      </div>
                                    </div>
                                  </div><!-- end products-item -->
                            </div>                      
                            @endforeach
                            @endif      
                        </div>

                        <div class="text-center">
                            {{ $productArr->links() }}                           
                        </div><!-- pagination -->

                    </div><!--/ end product-view -->
                </div><!--/ end block-main -->
            </div>
        </div>
@endsection