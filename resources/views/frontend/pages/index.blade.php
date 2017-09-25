@extends('frontend.layout')

@section('content')
<div class="block-headline-detail container" style="margin-top:10px">
  <ul class="breadcrumb breadcrumb-customize">
      <li><a href="{{ route('home') }}">{{ trans('text.trang-chu') }}</a></li>
      <li><a href="{{ $lang == 'vi' ? route('pages', $detail->slug_vi) : route('pages', $detail->slug_en) }}">{{ $lang == 'vi' ? $detail->title_vi : $detail->title_en }}</a></li>
  </ul>
</div>
<div class="container page">
<div class="row">
	
	@include('frontend.pages.sidebar')

	<div class="block-main col-lg-9 col-md-8 col-sm-8">
		<div class="page-view">

			<div class="title-page">
				<h2 class="page-title">{{ $lang == 'vi' ? $detail->title_vi : $detail->title_en }}</h2>
			</div>

			<div class="clearfix"></div>

			<div class="bg_gioithieu">
				<?php echo $lang == 'vi' ? $detail->content_vi : $detail->content_en; ?>
			</div>

		</div><!--/ end product-view -->
	</div><!--/ end block-main -->

	<div class="clearfix"></div>	

</div>
</div>
@endsection