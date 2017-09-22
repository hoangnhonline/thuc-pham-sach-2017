@extends('frontend.layout')

@section('content')
<div class="block-headline-detail container">
  <ul class="breadcrumb breadcrumb-customize">
      <li><a href="{{ route('home') }}">{{ trans('text.home') }}</a></li>
      <li><a href="{{ route('video') }}">Video</a></li>
  </ul>
</div>
<div class="container page">
  <div class="row">
      
    @include('frontend.detail.sidebar')

    <div class="block-main col-lg-9 col-md-8 col-sm-8">
      <div class="page-view">

        <div class="title-page">
          <h2 class="page-title">Video</h2>
        </div>

        <div class="clearfix"></div>

        <div class="page-layout-2columns page-child grid page-child-grid">
          <div class="page-child-items row">
            @if($videoList->count() > 0)
              @foreach($videoList as $video)
              <div class="page-child-item">
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

@endsection