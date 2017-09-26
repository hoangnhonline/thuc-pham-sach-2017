@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block-headline-detail container" style="margin-top:10px">
  <ul class="breadcrumb breadcrumb-customize">
      <li><a href="{{ route('home') }}">{{ trans('text.trang-chu') }}</a></li>
      <li><a href="{{ $lang == 'vi' ? route('album-vi') : route('album-en') }}">Hình ảnh</a></li>      
      <li><a href="{{ $lang == 'vi' ? route('chi-tiet-album', [$detail->slug_vi, $detail->id]) : route('chi-tiet-album', [$detail->slug_en, $detail->id]) }}">{{ $lang == 'vi' ? $detail->name_vi : $detail->name_en }}</a></li>
  </ul>
</div>
<div class="container page">
    <div class="row">
      
  @include('frontend.detail.sidebar')

  <div class="block-main col-lg-9 col-md-8 col-sm-8">
    <div class="page-view">

      <div class="title-page shop-tab-title">
        <h1 class="page-title">{{ $lang == 'vi' ? $detail->name_vi : $detail->name_en }}</h1>
      </div>

      <div class="clearfix"></div>

      <div class="albumdetail">
        <div class="contentdetail">          
          <ul id="imageGallery" class="imageGallery_ct">
            @foreach( $hinhArr as $hinh )            
            <li data-thumb="{{ Helper::showImage($hinh['image_url']) }}" data-src="{{ Helper::showImage($hinh['image_url']) }}">
              <img src="{{ Helper::showImage($hinh['image_url']) }}" />
            </li>
            @endforeach                        
          </ul>
          <div class="detail-album">
            <?php echo $lang == 'vi' ? $detail->content_vi : $detail->content_en; ?>
          </div>          
        </div>
      </div>

    </div><!--/ end product-view -->
  </div><!--/ end block-main -->

  <div class="clearfix"></div>
    </div>
  </div>
<style type="text/css">
  .shop-tab-title h1{
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    font-size: 20px;
  }
</style>
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
<link href="{{ URL::asset('public/assets/css/lightslider.css') }}" type="text/css" media="all" rel="stylesheet" />
  <!-- ===== Owl Lightgallery ===== -->
<link href="{{ URL::asset('public/assets/lightgallery/css/lightgallery.min.css') }}" type="text/css" media="all" rel="stylesheet" />
<script src="{{ URL::asset('public/assets/js/lightslider.js') }}"></script>
    <!-- Js lightslider Integrate with lightGallery -->
<script src="{{ URL::asset('public/assets/lightgallery/js/lightgallery.min.js') }}"></script>
<script>
    // Album details width thumbnail
    $(document).ready(function() {
      $('#imageGallery').lightSlider({
        gallery:true,
        item:1,
        loop:true,
        thumbItem:9,
        slideMargin:0,
        enableDrag: false,
        currentPagerPosition:'left',
        slideMargin: 0,
        speed:800,
        auto:true,
        loop:true,
        onSliderLoad: function(el) {
          el.lightGallery({
          selector: '#imageGallery .lslide',
          });
        }
      });
    });
  </script>

@endsection