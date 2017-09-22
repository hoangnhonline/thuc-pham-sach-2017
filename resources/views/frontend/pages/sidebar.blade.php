<div class="col-md-3 col-sm-4 col-xs-12 sidebar">
	<div class="sidebar-shop sidebar-left">
		<div class="widget widget-filter">
			<div class="box-filter category-filter">
				<h2 class="widget-title">{{ trans('text.danh-muc-san-pham') }}</h2>
				<ul>
					@foreach($loaiSp as $loai)
					<li><a href="{{ $lang == 'vi' ? route('danh-muc-cha', [$loai->slug_vi]) : route('danh-muc-cha', [$loai->slug_en]) }}" title="{{ $lang == 'vi' ? $loai->name_vi : $loai->name_en }}" {{ isset($rs) && $rs->id == $loai->id ? "class=active" : "" }}> {{ $lang == 'vi' ? $loai->name_vi : $loai->name_en }}</a></li>
					@endforeach	
				</ul>
			</div>
			
		</div>
	</div>
	<!-- End Sidebar Shop -->
</div>