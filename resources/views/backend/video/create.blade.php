@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Video      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('video.index') }}">Video</a></li>
      <li class="active">Tạo mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default" href="{{ route('video.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('video.store') }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tạo mới</h3>
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
                    <li role="presentation" class="active"><a href="#infoVi" aria-controls="infoVi" role="tab" data-toggle="tab">VN</a></li>                                    
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="infoVi">
                           <!-- text input -->
                           
                        <div class="form-group">
                          <label>Tên video <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="name_vi" id="name_vi" value="{{ old('name_vi') }}">
                        </div>
                        <div class="form-group">
                          <label>Slug <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="slug_vi" id="slug_vi" value="{{ old('slug_vi') }}">
                        </div>
                        <div class="form-group">
                          <label>URL video <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="video_url" id="video_url" value="{{ old('video_url') }}">
                        </div>
                      
                        <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                          <label class="col-md-3 row">Thumbnail </label>    
                          <div class="col-md-9">
                            <img id="thumbnail_image" src="{{ old('image_url') ? Helper::showImage(old('image_url')) : URL::asset('public/admin/dist/img/img.png') }}" class="img-thumbnail" width="145" height="85">
                            
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
                          <textarea class="form-control" rows="4" name="description_vi" id="description_vi">{{ old('description_vi') }}</textarea>
                        </div>
                    </div><!--end thong tin co ban-->                    
                   
                  </div>

                </div>       
                  
                
            </div>
            <!-- /.box-body -->        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('video.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">
        <!-- general form elements -->
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
                  </div>

                </div>              
            
        </div>
        <!-- /.box -->     

      </div>
      <!--/.col (left) -->      
    </div>
    <input type="hidden" name="image_url" id="image_url" value="{{ old('image_url') }}"/>          
    <input type="hidden" name="image_name" id="image_name" value="{{ old('image_name') }}"/>
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
      var editor = CKEDITOR.replace( 'description_vi',{
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
      $('#name_vi').change(function(){
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

    });
    
</script>
@stop
