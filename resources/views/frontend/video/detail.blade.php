@extends('frontend.layout')

@section('content')
<div class="block-headline-detail container">
  <ul class="breadcrumb breadcrumb-customize">
      <li><a href="{{ route('home') }}">{{ trans('text.home') }}</a></li>
      <li><a href="{{ route('video') }}">Video</a></li>      
      <li><a href="{{ $lang == 'vi' ? route('chi-tiet-album', [$detail->slug_vi, $detail->id]) : route('chi-tiet-album', [$detail->slug_en, $detail->id]) }}">{{ $lang == 'vi' ? $detail->name_vi : $detail->name_en }}</a></li>
  </ul>
</div>
<div class="container page">
  <div class="row">
      
  @include('frontend.detail.sidebar')

  <div class="block-main col-lg-9 col-md-8 col-sm-8">
    <div class="page-view">

      <div class="title-page">
        <h2 class="page-title">{{ trans('text.video-detail') }}</h2>
      </div>

      <div class="clearfix"></div>

      <div class="videodetail">
        <div class="contentdetail">
          <h1 class="tittle_video">{{ $lang == 'vi' ? $detail->name_vi : $detail->name_en }}</h1>
        </div>
        <div class="video_clip">
          <div class="videoWrapper">
            <iframe width="100%" height="500" src="{{ $detail->video_url }}" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
        <div class="textentry">
          <div class="vitext">
            <div class="more">
              <?php echo $lang == 'vi' ? $detail->description_vi : $detail->description_en; ?>           
            </div>
          </div>          
        </div>
        <div class="ttin_tag">
          <div class="top_tt">
            <img src="{{ URL::asset('public/assets/images/icon_ttin_tag.png') }}" class="ttin_left_tag">
            <div class="chu_tag">
              <a href="#">dây nịt nam</a>,
              <a href="#">day nit nam</a>,
              <a href="h#">day lung nam</a>,
              <a href="h#">dây lưng nam</a>,
              <a href="#">thắt lưng nam</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!--/ end block-main -->

  <div class="clearfix"></div>

    </div>
  </div>


@endsection