@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<div class="block-headline-detail container" style="margin-top:10px">
  <ul class="breadcrumb breadcrumb-customize">
      <li><a href="{{ route('home') }}">{{ trans('text.trang-chu') }}</a></li>
      <li><a href="{{ route('video') }}">Video</a></li>      
      <li><a href="{{ $lang == 'vi' ? route('video-detail', [$detail->slug_vi, $detail->id]) : route('video-detail', [$detail->slug_en, $detail->id]) }}">{{ $lang == 'vi' ? $detail->name_vi : $detail->name_en }}</a></li>
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

      <div class="videodetail">
        
        <div class="video_clip">
          <div class="videoWrapper">
            <iframe width="100%" height="500" src="{{ str_replace('watch?v=', 'embed/', $detail->video_url) }}?rel=0" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
        <div class="textentry">
          <div class="vitext">
            <div class="more">
              <?php echo $lang == 'vi' ? $detail->description_vi : $detail->description_en; ?>           
            </div>
          </div>          
        </div>
        
      </div>
    </div>
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
  .textentry {
    padding: 4px;
    margin: 15px 0;
    line-height: 20px;
}
</style>

@endsection