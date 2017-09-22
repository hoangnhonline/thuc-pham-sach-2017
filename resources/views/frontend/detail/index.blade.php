@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')

<div class="content-shop left-sidebar">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-sm-8 col-xs-12 main-content">
        <div class="main-content-shop">
          <div class="main-detail">
            <div class="row">
              <div class="col-md-5 col-sm-12 col-xs-12">
                @if( !empty( $hinhArr ))                    
                <div class="detail-gallery">
                  <div class="mid">
                    <img src="{{ Helper::showImage($hinhArr[0]['image_url']) }}" alt="slide"/>
                    <p><i class="fa fa-search"></i> {{ trans('text.re-chuot-phong-to') }}</p>
                  </div>
                  <div class="carousel">
                    <ul>
                      <?php $i = 0; ?>
                      @foreach( $hinhArr as $hinh )
                      <?php $i++; ?>
                      <li>
                        <a href="#" class="{{ $i==1 ? "active" : "" }}"><img src="{{ Helper::showImage($hinh['image_url']) }}" alt="detail {{ $i }}"/>
                        </a>
                      </li>
                      @endforeach                          
                    </ul>
                  </div>
                  <div class="gallery-control">
                    <a href="#" class="prev"><i class="fa fa-angle-left"></i></a>
                    <a href="#" class="next"><i class="fa fa-angle-right"></i></a>
                  </div>
                </div>
                @endif
                <!-- End Gallery -->
              </div>
              <div class="col-md-7 col-sm-12 col-xs-12">
                <div class="detail-info">
                  <h2 class="title-detail">{{ $lang == "vi" ? $detail->name_vi : $detail->name_en }}</h2>
                  
                  <div class="product-code">
                    <label>{{ trans('text.ma-sp') }}: </label> <span>#{{ $detail->code }}</span>
                  </div>        
                  <!-- I got these buttons from simplesharebuttons.com -->
                  <div id="share-buttons" style="margin-top:10px">
                      
                     
                      <!-- Facebook -->
                      <a href="http://www.facebook.com/sharer.php?u={{ url()->current() }}" target="_blank">
                          <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
                      </a>
                      
                      <!-- Google+ -->
                      <a href="https://plus.google.com/share?url={{ url()->current() }}" target="_blank">
                          <img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" />
                      </a>                      
                      <!-- Pinterest -->
                      <a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
                          <img src="https://simplesharebuttons.com/images/somacro/pinterest.png" alt="Pinterest" />
                      </a> 
                       
                      <!-- Twitter -->
                      <a href="https://twitter.com/share?url={{ url()->current() }}&amp;text={{ $lang == 'vi' ? $detail->name_vi : $detail->name_en }}&amp;hashtags=sanphamlamdepcaocap" target="_blank">
                          <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
                      </a>                     
                   

                  </div>   
                  <style type="text/css">
 
#share-buttons img {
width: 45px;
padding: 5px;
border: 0;
box-shadow: 0;
display: inline;
}
 
</style>          
                  <div class="info-price info-price-detail">
                    <label>{{ trans('text.gia') }}:</label> 
                    @if($detail->het_hang == 0)
                    @if($detail->is_sale == 1 && $detail->price_sale > 0)
                      <span>{{ number_format($detail->price_sale) }}$</span>
                      <del>{{ number_format($detail->price) }}$</del>
                    @else
                      
                      @if($lang == 'en' && $detail->price_vnd > 0)
                      <span>{{ $detail->price > 0 ? number_format($detail->price)."$" : "Liên hệ" }}</span>
                      <span>~&nbsp;{{ $detail->price_vnd > 0 ? number_format($detail->price_vnd)." VND" : "Liên hệ" }}</span>
                      @else
                      <span>{{ $detail->price_vnd > 0 ? number_format($detail->price_vnd)." VND" : "Liên hệ" }}</span>
                      @endif
                    @endif       
                    @else
                    <span class="het-hang">Tạm hết hàng</span>
                    @endif
                  </div>               
                  @if($detail->price_vnd > 0 && $detail->het_hang == 0)
                  <div class="attr-info">                              
                    <a class="addcart-link" href="javascript:;" data-id="{{ $detail->id }}"><i class="fa fa-shopping-cart"></i> {{ trans('text.mua-hang') }}</a>
                  <!-- End Attr Info -->
                  </div>
                  @endif
                </div>
                <!-- Detail Info -->
              </div>
            </div>
          </div>
          <!-- End Main Detail -->
          <div class="tab-detail">
            <div class="title-tab-detail">
              <ul role="tablist">
                <li class="active"><a href="#details" data-toggle="tab">{{ trans('text.chi-tiet-san-pham') }} </a></li>
                <li><a href="#feedback" data-toggle="tab">{{ trans('text.danh-gia') }}</a></li>                    
              </ul>
            </div>
            <div class="content-tab-detail">
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="details">
                  <?php $detailContent = $lang == "vi" ? $detail->content_vi : $detail->content_en; ?>
                  @if($detailContent)
                    <?php echo $detailContent; ?>
                  @else
                  <p style="padding:30px">{{ trans('text.noi-dung-dang-cap-nhat') }}</p>
                  @endif
                </div>
                <div role="tabpanel" class="tab-pane" id="feedback">
                  <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
                </div>                    
              </div>
            </div>
          </div>
          <!-- End Tab Detail -->
          @if($saleList->count() > 0)
          <div class="upsell-detail">
            <h2 class="title-default">{{ trans('text.san-pham-khuyen-mai') }}</h2>
            <div class="upsell-detail-slider">
              <div class="wrap-item">
                @foreach($saleList as $product)
                <div class="item">
                  <div class="item-product">
                    <div class="product-thumb">
                      <a class="product-thumb-link" href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->id]) }}">
                        <img class="first-thumb" alt="{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}" 1" src="{{ Helper::showImage($product->image_url) }}">
                        <img class="second-thumb" alt="{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}" 2" src="{{ Helper::showImage($product->image_url) }}">
                      </a>
                      <div class="product-info-cart">                       
                        <a class="addcart-link" href="javascript:;" data-id="{{ $product->id }}"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                      </div>
                    </div>
                    <div class="product-info">
                      <h3 class="title-product"><a href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->id]) }}">{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}</a></h3>
                      <div class="info-price">
                        @if($product->is_sale == 1 && $product->price_sale > 0)
                          <span>{{ number_format($product->price_sale) }}$</span>
                          <del>{{ number_format($product->price) }}$</del>
                        @else
                          <span>{{ $product->price > 0 ? number_format($product->price)."$" : "Liên hệ" }}</span>
                          @if($lang == 'en' && $product->price_vnd > 0)<br>
                          <span>{{ $product->price_vnd > 0 ? number_format($product->price_vnd)." VND" : "Liên hệ" }}</span>
                          @endif
                        @endif
                      </div>                     
                    </div>
                  </div>
                </div>
                @endforeach                
              </div>
            </div>
          </div>
          @endif
          <!-- End Upsell Detail -->
        </div>
        <!-- End Main Content Shop -->
      </div>
      @include('frontend.detail.sidebar-detail')
    </div>
  </div>
</div>
@endsection
@section('javascript')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=843110792495973";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<style type="text/css">
    .fb-comments, .fb-comments iframe[style], .fb-like-box, .fb-like-box iframe[style], .fb-comments span, .fb-comments iframe span[style], .fb-like-box span, .fb-like-box iframe span[style] 
{
       width: 100% !important;
}
</style>
<!-- Js zoom -->
<script type="text/javascript" src="{{ URL::asset('public/assets/js/jquery.jcarousellite.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('public/assets/js/jquery.elevatezoom.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('public/assets/js/slideshow/jquery.themepunch.revolution.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('public/assets/js/slideshow/jquery.themepunch.plugins.min.js') }}"></script>
@endsection