<option value="0">--chọn--</option>
@if(!empty( (array) $cateList ))
	@foreach($cateList as $cate)
	<option value="{{ $cate->id }}">{{ $cate->name_vi }}</option>
	@endforeach
@endif