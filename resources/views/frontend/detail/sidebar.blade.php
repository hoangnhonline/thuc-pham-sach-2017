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
			<!-- End Category -->
			<div class="box-filter price-filter">
				<h2 class="widget-title">{{ trans('text.khoang-gia') }}</h2>
				<div class="inner-price-filter" style="margin-bottom:20px">				
					<div class="slider-range">
                        <div id="slider-range"></div>
                        <div class="action" style="margin-top:10px">
                            <span class="price-range" style="height:1px"><span id="amount-left"></span> - <span id="amount-right"></span></span>
                        </div>
                    </div>
				</div>
			</div>
			<!-- End Manufacturers -->
		</div>	
		
	</div>
	<!-- End Sidebar Shop -->
</div>