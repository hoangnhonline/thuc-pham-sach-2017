@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="container">
<?php 
$lang_id = $lang == 'vi'  ? 1 : 2;
$bannerArr = DB::table('banner')->where(['object_id' => 1, 'object_type' => 3, 'lang_id' => $lang_id])->orderBy('display_order', 'asc')->get();
?>
@if($bannerArr)
  <div class="banner-slider5 simple-owl-slider">
    <div class="wrap-item">
      <?php $i = 0; ?>
      @foreach($bannerArr as $banner)
      <?php $i++; ?>
      <div class="item-banner5">
        <div class="banner-thumb">
          @if($banner->ads_url !='')
          <a href="{{ $banner->ads_url }}">
          @endif
          <img alt="decoos slide {{ $i }}" src="{{ Helper::showImage($banner->image_url) }}" title="thuc pham sach slide {{ $i }}">
          @if($banner->ads_url !='')
          </a>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
@endif
  @foreach($loaiSpList as $loaiSp)
  <!-- End Price Shipping -->
  <div class="content-popular11">
    <div class="popular-cat-title">
      <ul>
        <li class="active"><a href="{{ $lang == 'vi' ? route('danh-muc-cha', [$loaiSp->slug_vi]) : route('danh-muc-cha', [$loaiSp->slug_en]) }}" data-toggle="tab">{!! $lang == 'vi' ? $loaiSp->name_vi : $loaiSp->name_en !!}</a></li>
        @if(!empty($cateList[$loaiSp->id]))
        @foreach($cateList[$loaiSp->id] as $cate)      
        <li> <a href="{{ $lang == 'vi' ? route('danh-muc-con', [$loaiSp->slug_vi, $cate->slug_vi]) : route('danh-muc-con', [$loaiSp->slug_en, $cate->slug_en]) }}">{!! $lang == "vi" ? $cate->name_vi : $cate->name_en !!}</a>    </li> 
        @endforeach
        @endif
       
      </ul>
    </div>
    <div class="popular-cat-slider popular-cat-slider11 slider-home5">
      <div class="wrap-item">
        @if($productArr[$loaiSp->slug_vi]->count() > 0)
        @foreach($productArr[$loaiSp->slug_vi] as $product)
        <div class="item">
          <div class="item-product5">
            <div class="product-thumb product-thumb5">
              <a href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->id]) }}" class="product-thumb-link">
                <img class="first-thumb" src="{{ Helper::showImage($product->image_url) }}" alt="{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}"  />
                <img class="second-thumb" src="{{ Helper::showImage($product->image_url) }}" alt="{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}"  />              
              </a>
              @if($product->price > 0 || $product->price_vnd > 0)
              <div class="product-info-cart">                
                <a class="{{ $product->het_hang == 1 ? "het-hang" : 'addcart-link' }}" href="javascript:void(0)" data-id="{{ $product->id }}">@if($product->het_hang == 0) <i class="fa fa-shopping-basket"></i>@endif {!! $product->het_hang == 1 ? "Tạm hết hàng" : trans('text.mua-hang') !!}</a>
              </div>
              @endif
            </div>
            <div class="product-info5">
              <h3 class="title-product"><a href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->id]) }}">{!! $lang == 'vi' ? $product->name_vi : $product->name_en !!}</a></h3>
              <div class="info-price">
                @if($product->het_hang == 0)
                @if($product->is_sale == 1 && $product->price_sale > 0)
                  <span>{!! number_format($product->price_sale) !!}$</span>
                  <del>{!! number_format($product->price) !!}$</del>
                @else
                  
                  @if($lang == 'en' && $product->price_vnd > 0)
                  <span>{!! $product->price > 0 ? number_format($product->price)."$" : "Liên hệ" !!}</span><br>
                  <span>{!! $product->price_vnd > 0 ? number_format($product->price_vnd)." VND" : "Liên hệ" !!}</span>
                  @else
                  <span>{!! $product->price_vnd > 0 ? number_format($product->price_vnd) : "Liên hệ" !!}</span>
                  @endif
                @endif  
                @else
                <span class="het-hang">Tạm hết hàng</span>
                @endif             
              </div>             
            </div>
          </div>
        </div><!--items-->
        @endforeach
        @endif
      </div>
    </div>  
  </div>
  
  @endforeach
  
</div>
@endsection