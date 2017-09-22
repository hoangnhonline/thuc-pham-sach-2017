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
      <li><a href="{{ route('product.index') }}">Sản phẩm</a></li>
      <li class="active">Thêm mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('product.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('product.store') }}" id="dataForm">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thêm mới</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}          
            <div class="box-body">
                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                  </div>
                @endif
                <div>

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" data-editor="vi" class="tab_editor" aria-controls="home" role="tab" data-toggle="tab">Thông tin tiếng Việt</a></li>
                    <!--<li role="presentation"><a href="#homeEn" aria-controls="homeEn" data-editor="en" class="tab_editor" role="tab" data-toggle="tab">Thông tin English</a></li>-->
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Hình ảnh</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="form-group col-md-6 none-padding">
                          <label for="email">Danh mục cha<span class="red-star">*</span></label>
                          <select class="form-control" name="loai_id" id="loai_id">
                            <option value="">--Chọn--</option>
                            @foreach( $loaiSpArr as $value )
                            <option value="{{ $value->id }}" {{ $value->id == old('loai_id') || $value->id == $loai_id ? "selected" : "" }}>{{ $value->name_vi }}</option>
                            @endforeach
                          </select>
                        </div>
                          <div class="form-group col-md-6 none-padding pleft-5">
                          <label for="email">Danh mục con</label>

                          <select class="form-control" name="cate_id" id="cate_id">
                            <option value="">--Chọn--</option>
                            @foreach( $cateArr as $value )
                            <option value="{{ $value->id }}" {{ $value->id == old('cate_id') || $value->id == $cate_id ? "selected" : "" }}>{{ $value->name_vi }}</option>
                            @endforeach
                          </select>
                        </div>  
                        <div class="form-group" >                  
                          <label>Mã <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}">
                        </div>
                        <div class="form-group" >                  
                          <label>Tên <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="name_vi" id="name_vi" value="{{ old('name_vi') }}">
                        </div>
                         <input type="hidden" class="form-control" name="slug_vi" id="slug_vi" value="{{ old('slug_vi') }}">
                                            
                        <div class="col-md-4 none-padding">
                          <div class="checkbox">
                              <label><input type="checkbox" name="is_hot" value="1"> Sản phẩm HOT </label>
                          </div>                          
                        </div>
                        <div class="col-md-4 none-padding pleft-5">
                            <div class="checkbox">
                              <label><input type="checkbox" name="is_sale" value="1"> Sản phẩm SALE </label>
                          </div>
                        </div>
                        <div class="col-md-4 none-padding pleft-5">
                            <div class="checkbox">
                              <label><input type="checkbox" name="het_hang" value="1"> HẾT HÀNG </label>
                          </div>
                        </div>

                        <!--<div class="form-group col-md-6  none-padding" >                  
                            <label>Giá USD ( $ )</label>
                            <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
                        </div> -->
                        <div class="form-group" >                  
                            <label>Giá VNĐ</label>
                            <input type="text" class="form-control" name="price_vnd" id="price_vnd" value="{{ old('price_vnd') }}">
                        </div>
                                               
                        <div class="form-group" >                  
                          <label>Màu sắc</label>
                          <select name="color_id" class="form-control">
                            <option value="0">--select--</option>
                            @foreach($colorList as $color)
                            <option value="{{ $color->id  }}" {{ old('color_id') == $color->id ? "selected" : ""}}>{{ $color->name }}</option>
                            @endforeach
                          </select>
                        </div>
                       
                        <div class="form-group">                  
                          <label>Video URL</label>                  
                          <input type="text" class="form-control" name="video_url" id="video_url" value="{{ old('video_url') }}">
                        </div>
                         <!--<div class="form-group">
                          <label>Tags VI</label>
                          <select class="form-control select2" name="tags_vi[]" id="tags_vi" multiple="multiple" style="width:100% !important;">                  
                            @if( $tagViList->count() > 0)
                              @foreach( $tagViList as $value )
                              <option value="{{ $value->id }}" {{ old('tags') && in_array($value->id, old('tags_vi') ) ? "selected" : "" }}>{{ $value->name }}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>-->
                         <div class="form-group">
                          <label>Chi tiết</label>
                          <textarea class="form-control" rows="10" name="content_vi" id="content_vi">{{ old('content_vi') }}</textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div><!--end thong tin co ban--> 
                    <div role="tabpanel" class="tab-pane" id="homeEn">                        
                        <div class="form-group" >                  
                          <label>Name <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="name_en" id="name_en" value="{{ old('name_en') }}">
                        </div>
                        <input type="hidden" class="form-control" name="slug_en" id="slug_en" value="{{ old('slug_en') }}">                       
                         <div class="form-group">
                          <label>Detail</label>
                          <textarea class="form-control" rows="10" name="content_en" id="content_en">{{ old('content_en') }}</textarea>
                        </div>
                        <!--<div class="form-group">
                          <label>Tags EN</label>
                          <select class="form-control select2" name="tags_en[]" id="tags_en" multiple="multiple" style="width:100% !important;">                  
                            @if( $tagEnList->count() > 0)
                              @foreach( $tagEnList as $value )
                              <option value="{{ $value->id }}" {{ old('tags') && in_array($value->id, old('tags_en') ) ? "selected" : "" }}>{{ $value->name }}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>-->
                        <div class="clearfix"></div>
                    </div><!--end thong tin co ban--> 
                     <div role="tabpanel" class="tab-pane" id="settings">
                        <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                         
                          <div class="col-md-12" style="text-align:center">                            
                            
                            <input type="file" id="file-image"  style="display:none" multiple/>
                         
                            <button class="btn btn-primary" id="btnUploadImage" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                            <div class="clearfix"></div>
                            <div id="div-image" style="margin-top:10px"></div>
                          </div>
                          <div style="clear:both"></div>
                        </div>

                     </div><!--end hinh anh--> 
                  </div>

                </div>
                  
            </div>
            <div class="box-footer">             
              <button type="button" class="btn btn-default" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary" id="btnSave" onclick="return validateData(); ">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('product.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     
<input type="hidden" id="editor_active" value="vi" />
      </div>
      <div class="col-md-4">      
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thông tin SEO</h3>
          </div>

          <!-- /.box-header -->
            <div class="box-body">

               <div>

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#seoVi" aria-controls="seoVi" role="tab" data-toggle="tab">VN</a></li>
                    <!--<li role="presentation"><a href="#seoEn" aria-controls="seoEn" role="tab" data-toggle="tab">EN</a></li>                    -->
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="seoVi">
                         <div class="form-group">
                            <label>Thẻ title </label>
                            <input type="text" class="form-control" name="meta_title_vi" id="meta_title_vi" value="{{ old('meta_title_vi') }}">
                          </div>
                          <!-- textarea -->
                          <div class="form-group">
                            <label>Thẻ desciption</label>
                            <textarea class="form-control" rows="6" name="meta_description_vi" id="meta_description_vi">{{ old('meta_description_vi') }}</textarea>
                          </div>  

                          <div class="form-group">
                            <label>Thẻ keywords</label>
                            <textarea class="form-control" rows="4" name="meta_keywords_vi" id="meta_keywords_vi">{{ old('meta_keywords_vi') }}</textarea>
                          </div>  
                          <div class="form-group">
                            <label>Nội dung tùy chỉnh</label>
                            <textarea class="form-control" rows="6" name="custom_text_vi" id="custom_text_vi">{{ old('custom_text_vi') }}</textarea>
                          </div>
                    </div><!--end thong tin co ban--> 
                    <div role="tabpanel" class="tab-pane" id="seoEn">                        
                        <div class="form-group">
                            <label>Meta title </label>
                            <input type="text" class="form-control" name="meta_title_en" id="meta_title_en" value="{{ old('meta_title_en') }}">
                          </div>
                          <!-- textarea -->
                          <div class="form-group">
                            <label>Meta desciption</label>
                            <textarea class="form-control" rows="6" name="meta_description_en" id="meta_description_en">{{ old('meta_description_en') }}</textarea>
                          </div>  

                          <div class="form-group">
                            <label>Meta keywords</label>
                            <textarea class="form-control" rows="4" name="meta_keywords_en" id="meta_keywords_en">{{ old('meta_keywords_en') }}</textarea>
                          </div>  
                          <div class="form-group">
                            <label>Custom text</label>
                            <textarea class="form-control" rows="6" name="custom_text_en" id="custom_text_en">{{ old('custom_text_en') }}</textarea>
                          </div>
                    </div><!--end thong tin co ban--> 
                   
                  </div>

                </div>


             
            
        </div>
        <!-- /.box -->     

      </div>
      <!--/.col (left) -->      
    </div>
 <input type="hidden" name="image_pro" id="image_pro" value="{{ old('image_pro') }}"/> 
 <input type="hidden" name="pro_name" id="pro_name" value="{{ old('pro_name') }}"/>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image_multiple" value="{{ route('image.tmp-upload-multiple') }}">
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
<style type="text/css">
  .nav-tabs>li.active>a{
    color:#FFF !important;
    background-color: #28AA4A !important;
  }

</style>
@stop
@section('javascript_page')
<script type="text/javascript">
$(document).on('click', '.remove-image', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    $(this).parents('.col-md-3').remove();
  }
});
function validateData(){
  if($('#loai_id').val() == 0){
    alert('Chưa chọn danh mục cha.'); return false;
  } 
  return true;  
}
    $(document).ready(function(){
      $('.tab_editor').click(function(){
        var active = $(this).attr('data-editor');
        $('#editor_active').val(active);
      });
      $('#loai_id').change(function(){
        var loai_id = $(this).val();
        
        $.ajax({
              url: "{{ route('cate.ajax-list-by-parent') }}",
              type: "POST",
              async: false,      
              data: {
                loai_id : loai_id
              },              
              success: function (response) {
                $('#cate_id').html(response);              
              }              
            });
      });
      $(".select2").select2();
      $('#dataForm').submit(function(){
        
        if( $('#loai_id').val() == 0){
          swal("Lỗi!", "Chưa chọn danh mục cha", "error");
          return false;
        }       
        
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
      var editor = CKEDITOR.replace( 'content_vi',{
          language : 'vi',
          height: 300,
          removeButtons : 'Image',
          filebrowserBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=files') }}",
          filebrowserImageBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=images') }}",
          filebrowserFlashBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=flash') }}",
          filebrowserUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=files') }}",
          filebrowserImageUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=images') }}",
          filebrowserFlashUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=flash') }}"
      });
      var editor2 = CKEDITOR.replace( 'content_en',{
          language : 'vi',
          height: 300,
          removeButtons : 'Image',
          filebrowserBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=files') }}",
          filebrowserImageBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=images') }}",
          filebrowserFlashBrowseUrl: "{{ URL::asset('/backend/dist/js/kcfinder/browse.php?type=flash') }}",
          filebrowserUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=files') }}",
          filebrowserImageUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=images') }}",
          filebrowserFlashUploadUrl: "{{ URL::asset('/backend/dist/js/kcfinder/upload.php?type=flash') }}"
      });
      
      $('#btnUploadImage').click(function(){        
        $('#file-image').click();
      }); 
     
      var files = "";
      $('#file-image').change(function(e){
         files = e.target.files;
         
         if(files != ''){
           var dataForm = new FormData();        
          $.each(files, function(key, value) {
             dataForm.append('file[]', value);
          });   
          
          dataForm.append('date_dir', 0);
          dataForm.append('folder', 'tmp');

          $.ajax({
            url: $('#route_upload_tmp_image_multiple').val(),
            type: "POST",
            async: false,      
            data: dataForm,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#div-image').append(response);
                if( $('input.thumb:checked').length == 0){
                  $('input.thumb').eq(0).prop('checked', true);
                }
            },
            error: function(response){                             
                var errors = response.responseJSON;
                for (var key in errors) {
                  
                }
                //$('#btnLoading').hide();
                //$('#btnSave').show();
            }
          });
        }
      });
     

      $('#name_vi').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' ){
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug_vi').val( response.str );
                }                
              },
              error: function(response){                             
                  var errors = response.responseJSON;
                  for (var key in errors) {
                    
                  }
                  //$('#btnLoading').hide();
                  //$('#btnSave').show();
              }
            });
         }
      });
      $('#name_en').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' ){
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug_en').val( response.str );
                }                
              },
              error: function(response){                             
                  var errors = response.responseJSON;
                  for (var key in errors) {
                    
                  }
                  //$('#btnLoading').hide();
                  //$('#btnSave').show();
              }
            });
         }
      }); 
    });
    
</script>
@stop
