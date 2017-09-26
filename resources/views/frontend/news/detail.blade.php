@extends('frontend.layout')

@section('content')
<div class="block-headline-detail container" style="margin-top:10px">
  <ul class="breadcrumb breadcrumb-customize">
      <li><a href="{{ route('home') }}">Trang chủ</a></li>
      <li><a href="{{ $lang == 'vi' ? route('news-vi') : route('news-en') }}">{!! $lang == 'vi' ? "Tin tức" : "News" !!}</a></li>
      <li><a href="{{ $lang == 'vi' ? route('news-detail-vi', [$detail->slug, $detail->id]) : route('news-detail-en', [$detail->slug, $detail->id]) }}">{!! $detail->title !!}</a></li>
  </ul>
</div>
<div class="container page">
          <div class="row">
            
        @include('frontend.detail.sidebar')

        <div class="block-main col-lg-9 col-md-8 col-sm-8">
          <div class="page-view">

            <div class="clearfix"></div>

            <div class="newsdetail">
              <div class="contentdetail shop-tab-title">
                <h1 style="font-size:27px">{!! $detail->title !!}</h1>
                <div class="contentdetail-content">
                    {!! $detail->content !!}
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
    font-size: 20px;
    margin-bottom: 15px;
  }
</style>
@endsection