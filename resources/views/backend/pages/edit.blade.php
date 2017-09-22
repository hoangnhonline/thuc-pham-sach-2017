@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cập nhật trang
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('pages.index') }}">Trang</a></li>
      <li class="active">Chỉnh sửa</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default" href="{{ route('pages.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('pages.update') }}">
    <input type="hidden" name="id" value="{{ $detail->id }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Chỉnh sửa</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if(Session::has('message'))
              <p class="alert alert-info" >{{ Session::get('message') }}</p>
              @endif
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
                    <li role="presentation" class="active"><a href="#infoVi" aria-controls="infoVi" role="tab" data-toggle="tab">VN</a></li>
                    <li role="presentation"><a href="#infoEn" aria-controls="infoEn" role="tab" data-toggle="tab">EN</a></li>                    
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="infoVi">
                           <!-- text input -->
                           
                        <div class="form-group">
                          <label>Tiêu đề <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="title_vi" id="title_vi" value="{{ old('title_vi') ? old('title_vi') : $detail->title_vi }}">
                        </div>
                        <div class="form-group">
                          <label>Slug <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="slug_vi" id="slug_vi" value="{{ old('slug_vi') ? old('slug_vi') : $detail->slug_vi }}">
                        </div>                                                                
                        <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                          <label class="col-md-3 row">Thumbnail </label>    
                          <div class="col-md-9">
                            <img id="thumbnail_image" src="{{ $detail->image_url ? Helper::showImage($detail->image_url ) : URL::asset('public/admin/dist/img/img.png') }}" class="img-thumbnail" width="145" height="85">
                            
                            <input type="file" id="file-image" style="display:none" />
                         
                            <button class="btn btn-default" id="btnUploadImage" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                          </div>
                          <div style="clear:both"></div>
                        </div>
                        <div class="clearfix"></div>  
                        <div class="clearfix"></div>
                        <!-- textarea -->
                        <div class="form-group">
                          <label>Mô tả</label>
                          <textarea class="form-control" rows="6" name="description_vi" id="description_vi">{{ old('description_vi') ? old('description_vi') : $detail->description_vi }}</textarea>
                        </div>
                        <div class="form-group">
                          <label>Chi tiết</label>
                          <textarea class="form-control" rows="10" name="content_vi" id="content_vi">{{ old('content_vi') ? old('content_vi') : $detail->content_vi }}</textarea>
                        </div>
                    </div><!--end thong tin co ban--> 
                    <div role="tabpanel" class="tab-pane" id="infoEn">                        
                          <!-- text input -->
                        <div class="form-group">
                          <label>Name <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="title_en" id="title_en" value="{{ old('title_en') ? old('title_en') : $detail->title_en }}">
                        </div>
                        <div class="form-group">
                          <label>Slug <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="slug_en" id="slug_en" value="{{ old('slug_en') ? old('slug_en') : $detail->slug_en }}">
                        </div>                         
                        <!-- textarea -->
                        <div class="form-group">
                          <label>Description</label>
                          <textarea class="form-control" rows="6" name="description_en" id="description_en">{{ old('description_en') ? old('description_en') : $detail->description_en }}</textarea>
                        </div>
                        <div class="form-group">
                          <label>Content</label>
                          <textarea class="form-control" rows="10" name="content_en" id="content_en">{{ old('content_en') ? old('content_en') : $detail->content_en }}</textarea>
                        </div>
                    </div><!--end thong tin co ban--> 
                   
                  </div>

                </div>       
                  
                
            </div>
            <!-- /.box-body -->        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('pages.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">      
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thông tin SEO</h3>
          </div>

          <!-- /.box-header -->
            <div class="box-body">
              <input type="hidden" name="meta_id" value="{{ $detail->meta_id }}">
               <div>

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#seoVi" aria-controls="seoVi" role="tab" data-toggle="tab">VN</a></li>
                    <li role="presentation"><a href="#seoEn" aria-controls="seoEn" role="tab" data-toggle="tab">EN</a></li>                    
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="seoVi">
                         <div class="form-group">
                            <label>Thẻ title </label>
                            <input type="text" class="form-control" name="meta_title_vi" id="meta_title_vi" value="{{ !empty((array)$meta) ? $meta->title_vi : "" }}">
                          </div>
                          <!-- textarea -->
                          <div class="form-group">
                            <label>Thẻ desciption</label>
                            <textarea class="form-control" rows="6" name="meta_description_vi" id="meta_description_vi">{{ !empty((array)$meta) ? $meta->description_vi : "" }}</textarea>
                          </div>  

                          <div class="form-group">
                            <label>Thẻ keywords</label>
                            <textarea class="form-control" rows="4" name="meta_keywords_vi" id="meta_keywords_vi">{{ !empty((array)$meta) ? $meta->keywords_vi : "" }}</textarea>
                          </div>  
                          <div class="form-group">
                            <label>Nội dung tùy chỉnh</label>
                            <textarea class="form-control" rows="6" name="custom_text_vi" id="custom_text_vi">{{ !empty((array)$meta) ? $meta->custom_text_vi : ""  }}</textarea>
                          </div>
                    </div><!--end thong tin co ban--> 
                    <div role="tabpanel" class="tab-pane" id="seoEn">                        
                        <div class="form-group">
                            <label>Meta title </label>
                            <input type="text" class="form-control" name="meta_title_en" id="meta_title_en" value="{{ !empty((array)$meta) ? $meta->title_en : "" }}">
                          </div>
                          <!-- textarea -->
                          <div class="form-group">
                            <label>Meta desciption</label>
                            <textarea class="form-control" rows="6" name="meta_description_en" id="meta_description_en">{{ !empty((array)$meta) ? $meta->description_en : "" }}</textarea>
                          </div>  

                          <div class="form-group">
                            <label>Meta keywords</label>
                            <textarea class="form-control" rows="4" name="meta_keywords_en" id="meta_keywords_en">{{ !empty((array)$meta) ? $meta->keywords_en : "" }}</textarea>
                          </div>  
                          <div class="form-group">
                            <label>Custom text</label>
                            <textarea class="form-control" rows="6" name="custom_text_en" id="custom_text_en">{{ !empty((array)$meta) ? $meta->custom_text_en : ""  }}</textarea>
                          </div>
                    </div><!--end thong tin co ban--> 
                   
                  </div>
                  <input type="hidden" name="image_url" id="image_url" value="{{ $detail->image_url }}"/>          
                  <input type="hidden" name="image_name" id="image_name" value="{{ $detail->image_name }}"/>
                </div>             
            
          </div>
        <!-- /.box -->     

      </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
@stop
@section('javascript_page')
<script type="text/javascript">
    $(document).ready(function(){  
      $(".select2").select2();   
        var editor = CKEDITOR.replace( 'content_vi',{
            language : 'vi',
            height: 300,
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
               dataForm.append('file', value);
            });   
            
            dataForm.append('date_dir', 1);
            dataForm.append('folder', 'tmp');

            $.ajax({
              url: $('#route_upload_tmp_image').val(),
              type: "POST",
              async: false,      
              data: dataForm,
              processData: false,
              contentType: false,
              success: function (response) {
                if(response.image_path){
                  $('#thumbnail_image').attr('src',$('#upload_url').val() + response.image_path);
                  $( '#image_url' ).val( response.image_path );
                  $( '#image_name' ).val( response.image_name );
                }
                console.log(response.image_path);
                  //window.location.reload();
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
      $('#title_vi').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' && $('#slug_vi').val() == ''){
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
      $('#title_en').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' && $('#slug_en').val() == ''){
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
