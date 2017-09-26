@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block-headline-detail container" style="margin-top:10px">
  <ul class="breadcrumb breadcrumb-customize">
      <li><a href="{{ route('home') }}">{{ trans('text.trang-chu') }}</a></li>
      <li><a href="{{ route('video') }}">Video</a></li>
  </ul>
</div>
<div class="container page">
  <div class="row">
      
    @include('frontend.detail.sidebar')

    <div class="block-main col-lg-9 col-md-8 col-sm-8">
      <div class="page-view">

        <div class="title-page shop-tab-title">
          <h1 class="page-title">Video</h1>
        </div>

        <div class="clearfix"></div>

        <div class="page-layout-2columns page-child grid page-child-grid">
          <div class="page-child-items row">
            @if($videoList->count() > 0)
              @foreach($videoList as $video)
              <div class="page-child-item col-md-4">
                <div class="album-item">
                   <a href="{{ $lang == 'vi' ? route('video-detail', [$video->slug_vi, $video->id]) : route('video-detail', [$video->slug_en, $video->id]) }}" title="{{ $lang == 'vi' ? $video->name_vi : $video->name_en }}">
                    <i class="icofont icofont-search-alt-1"></i>
                  </a>
                  <div class="album-img">
                        <img src="{{ Helper::showImage($video->image_url) }}" alt="{{ $lang == 'vi' ? $video->name_vi : $video->name_en }}">
                      </div>
                  <div class="album-info">
                    <h2 class="album-info-name">
                       <a href="{{ $lang == 'vi' ? route('video-detail', [$video->slug_vi, $video->id]) : route('video-detail', [$video->slug_en, $video->id]) }}" title="{{ $lang == 'vi' ? $video->name_vi : $video->name_en }}">{{ $lang == 'vi' ? $video->name_vi : $video->name_en }}</a>
                    </h2>
                  </div>
                </div>
              </div><!-- end page child item -->                       
              @endforeach
            @endif
          </div><!-- end page child items -->

          <div class="text-center pagination-custom">
              {{ $videoList->links() }}
          </div><!-- pagination -->
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
.album-item {
    position: relative;
    margin-top: 10px;
    overflow: hidden;
    transition: all 0.4s ease-out 0s;
    -webkit-transition: all 0.4s ease-out 0s;
    -o-transition: all 0.4s ease-out 0s;
    -ms-transition: all 0.4s ease-out 0s;
    text-align: center;
    height: 270px;
}
.album-item:hover {
    -webkit-box-shadow: 4px -2px 5px 0px rgba(245,245,245,1);
    -moz-box-shadow: 4px -2px 5px 0px rgba(245,245,245,1);
    box-shadow: 4px -2px 5px 0px rgba(245,245,245,1);
    -webkit-transition: all 0.4s ease-out 0s;
    -o-transition: all 0.4s ease-out 0s;
    -ms-transition: all 0.4s ease-out 0s;
}
.page-child-item {
    width: 33.33333333%;
    float: left;
    padding: 0 15px;
}

.album-info {
    height: 44px;
    padding: 5px;
    position: absolute;
    bottom: 0px;
    display: block;
    background: rgba(180, 180, 180, 0.5);
    width: 100%;
    z-index: 1;
}
.album-img {
    position: relative;
    margin-bottom: 5px;
    text-align: center;
    max-height: 270px;
}
.album-info-name a {
    color: #252525;
    font-size: 16px;
    display: block;
    margin-top: -10px;
}
</style>
@endsection