@extends('frontend.layout')

@section('content')
<div class="block-headline-detail container" style="margin-top:10px">
  <ul class="breadcrumb breadcrumb-customize">
      <li><a href="{{ route('home') }}">Trang chủ</a></li>
      <li><a href="{{ $lang == 'vi' ? route('news-vi') : route('news-en') }}">{{ $lang == 'vi' ? "Tin tức" : "News" }}</a></li>
      <li><a href="{{ $lang == 'vi' ? route('news-detail-vi', [$detail->slug, $detail->id]) : route('news-detail-en', [$detail->slug, $detail->id]) }}">{{ $detail->title }}</a></li>
  </ul>
</div>
<div class="container page">
          <div class="row">
            
        @include('frontend.detail.sidebar')

        <div class="block-main col-lg-9 col-md-8 col-sm-8">
          <div class="page-view">

            <div class="clearfix"></div>

            <div class="newsdetail">
              <div class="contentdetail">
                <h1 style="font-size:27px">{{ $detail->title }}</h1>
                <div class="contentdetail-content">
                    <?php echo $detail->content; ?>
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

          </div><!--/ end product-view -->
        </div><!--/ end block-main -->

        <div class="clearfix"></div>
          </div>
        </div>

@endsection