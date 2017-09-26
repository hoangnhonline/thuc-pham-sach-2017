@extends('layout.backend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Sản phẩm
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'product.index' ) }}">Sản phẩm</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('product.create', ['loai_id' => $arrSearch['loai_id'], 'cate_id' => $arrSearch['cate_id']]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('product.index') }}">
           
          
            
            <div class="form-group">
              <label for="email">Danh mục cha</label>
              <select class="form-control" name="loai_id" id="loai_id">
                <option value="">--Tất cả--</option>
                @foreach( $loaiSpArr as $value )
                <option value="{{ $value->id }}" {{ $value->id == $arrSearch['loai_id'] ? "selected" : "" }}>{{ $value->name_vi }}</option>
                @endforeach
              </select>
            </div>
              <div class="form-group">
              <label for="email">Danh mục con</label>

              <select class="form-control" name="cate_id" id="cate_id">
                <option value="">--Tất cả--</option>
                @foreach( $cateArr as $value )
                <option value="{{ $value->id }}" {{ $value->id == $arrSearch['cate_id'] ? "selected" : "" }}>{{ $value->name_vi }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="email">Tên</label>
              <input type="text" class="form-control" name="name" value="{{ $arrSearch['name'] }}">
            </div>
            <!--<div class="form-group">
              <label for="email">Ẩn/hiện :</label>
              <label class="radio-inline"><input type="radio" {{ $arrSearch['status'] == 1 ? "checked" : "" }} name="status" value="1">Hiện</label>
              <label class="radio-inline"><input type="radio" {{ $arrSearch['status'] == 0 ? "checked" : "" }} name="status" value="0">Ẩn</label>              
            </div>-->
            <div class="form-group">
              <label><input type="checkbox" name="is_hot" value="1" {{ $arrSearch['is_hot'] == 1 ? "checked" : "" }}> Hiện trang chủ</label>              
            </div>
            <div class="form-group">
              <label><input type="checkbox" name="is_sale" value="1" {{ $arrSearch['is_sale'] == 1 ? "checked" : "" }}> Giảm giá</label>              
            </div>            
            <button type="submit" style="margin-top:-5px" class="btn btn-primary btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( {{ $items->total() }} sản phẩm )</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <form method="post" action={{ route('product.save-order')}} >
           @if($arrSearch['loai_id'] > 0 || $arrSearch['cate_id'] > 0 )
          <button type="submit" class="btn btn-warning btn-sm">Cập nhật thứ tự</button>
          @endif
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
          </div>  
          
            {{ csrf_field() }}
            <input type="hidden" name="loai_id" value="{{ $arrSearch['loai_id'] }}">
            <input type="hidden" name="cate_id" value="{{ $arrSearch['cate_id'] }}">
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              @if($arrSearch['loai_id'] > 0 || $arrSearch['cate_id'] > 0 )
              <th style="width: 1%;white-space:nowrap">Thứ tự</th>
              @endif
              <th width="100px">Hình ảnh</th>
              <th style="text-align:center">Thông tin sản phẩm</th>                              
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; 

                ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
                @if($arrSearch['loai_id'] > 0 || $arrSearch['cate_id'] > 0 )
                <td style="vertical-align:middle;text-align:center">
                  <input type="text" name="display_order[]" value="{{ $item->display_order }}" class="form-control" style="width:40px; float:left;margin-right:10px">
                  <input type="hidden" name="product_id[]" value="{{ $item->id }}" class="form-control" style="width:40px; float:left;margin-right:10px">
                </td>
                @endif
                <td>
                  <img class="img-thumbnail lazy" width="80" data-original="{{ $item->image_url ? Helper::showImage($item->image_url) : URL::asset('public/admin/dist/img/no-image.jpg') }}" alt="Nổi bật" title="Nổi bật" />
                </td>
                <td>                  
                  <a style="color:#333;font-weight:bold" href="{{ route( 'product.edit', [ 'id' => $item->id ]) }}">{{ $item->name_vi }}</a> &nbsp; @if( $item->is_hot == 1 )
                  <label class="label label-danger"> HOT </label>
                  @endif<br />
                  <strong style="color:#337ab7;font-style:italic"> {{ $item->ten_loai }}  {{ $item->ten_cate }}</strong>
                 <p style="margin-top:10px">                    
                    <p style="color:red">{{ number_format($item->price_vnd) }} đ</p>
                  </p>
                  
                </td>
                <td style="white-space:nowrap; text-align:right">
                  <a class="btn btn-default btn-sm" href="{{ route('chi-tiet-vi', [$item->slug_vi, $item->id] ) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>                    
                  <a href="{{ route( 'product.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>                 

                  <a onclick="return callDelete('{{ $item->name_vi }}','{{ route( 'product.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm">Xóa</a>

                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
          </form>
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
          </div>  
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<style type="text/css">
#searchForm div{
  margin-right: 7px;
}
</style>
@stop
@section('javascript_page')
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn muốn xóa "' + name +'"?',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
$(document).ready(function(){
  $('input.submitForm').click(function(){
    var obj = $(this);
    if(obj.prop('checked') == true){
      obj.val(1);      
    }else{
      obj.val(0);
    } 
    obj.parent().parent().parent().submit(); 
  });
  
  $('#loai_id').change(function(){
    $('#cate_id').val('');
    $('#searchForm').submit();
  });
  $('#cate_id').change(function(){
    $('#searchForm').submit();
  });
  $('#table-list-data tbody').sortable({
        placeholder: 'placeholder',
        handle: ".move",
        start: function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("highlight");
        },          
        axis: "y",
        update: function() {
            var rows = $('#table-list-data tbody tr');
            var strOrder = '';
            var strTemp = '';
            for (var i=0; i<rows.length; i++) {
                strTemp = rows[i].id;
                strOrder += strTemp.replace('row-','') + ";";
            }     
            updateOrder("san_pham", strOrder);
        }
    });
});
function updateOrder(table, strOrder){
  $.ajax({
      url: $('#route_update_order').val(),
      type: "POST",
      async: false,
      data: {          
          str_order : strOrder,
          table : table
      },
      success: function(data){
          var countRow = $('#table-list-data tbody tr span.order').length;
          for(var i = 0 ; i < countRow ; i ++ ){
              $('span.order').eq(i).html(i+1);
          }                        
      }
  });
}
</script>
@stop