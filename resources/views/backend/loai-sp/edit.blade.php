@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Danh mục cha      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('loai-sp.index') }}">Danh mục cha</a></li>
      <li class="active">Chỉnh sửa</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default" href="{{ route('loai-sp.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('loai-sp.update') }}">
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
                          <label>Tên danh mục <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="name_vi" id="name_vi" value="{{ old('name_vi') ? old('name_vi') : $detail->name_vi }}">
                        </div>
                        <div class="form-group">
                          <label>Slug <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="slug_vi" id="slug_vi" value="{{ old('slug_vi') ? old('slug_vi') : $detail->slug_vi }}">
                        </div>
                          <div class="clearfix"></div>
                        <div class="form-group" style="margin-top:15px;padding-bottom:25px !important;">                         
                          <div class="checkbox col-md-12" >
                            <label>
                              <input type="checkbox" name="is_menu" value="1" {{ $detail->is_menu == 1 ? "checked" : "" }}>
                              Hiện menu
                            </label>
                          </div>                 
                        </div>
                        <div class="clearfix"></div>
                        <!-- textarea -->
                        <div class="form-group">
                          <label>Mô tả</label>
                          <textarea class="form-control" rows="4" name="description_vi" id="description_vi">{{ old('description_vi') ? old('description_vi') : $detail->description_vi }}</textarea>
                        </div>
                    </div><!--end thong tin co ban--> 
                    <div role="tabpanel" class="tab-pane" id="infoEn">                        
                          <!-- text input -->
                        <div class="form-group">
                          <label>Name <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="name_en" id="name_en" value="{{ old('name_en') ? old('name_en') : $detail->name_en }}">
                        </div>
                        <div class="form-group">
                          <label>Slug <span class="red-star">*</span></label>
                          <input type="text" class="form-control" name="slug_en" id="slug_en" value="{{ old('slug_en') ? old('slug_en') : $detail->slug_en }}">
                        </div>                  
                        <!-- textarea -->
                        <div class="form-group">
                          <label>Description</label>
                          <textarea class="form-control" rows="4" name="description_en" id="description_en">{{ old('description_en') ? old('description_en') : $detail->description_en }}</textarea>
                        </div>
                    </div><!--end thong tin co ban--> 
                   
                  </div>

                </div>       
                  
                
            </div>
            <!-- /.box-body -->        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('loai-sp.index')}}">Hủy</a>
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

                </div>             
            
          </div>
        <!-- /.box -->     

      </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop
@section('javascript_page')
<script type="text/javascript">
    $(document).ready(function(){     
      
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
      $('#name_en').change(function(){
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
