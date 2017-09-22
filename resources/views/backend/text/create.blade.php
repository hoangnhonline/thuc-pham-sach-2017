@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tạo tài khoản
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('text.index') }}">Tài khoản</a></li>
      <li class="active">Tạo mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('text.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('text.store') }}" id="formData">
    <div class="row">
      <!-- left column -->

      <div class="col-md-12">
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
              <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div>
               <div class="row">  
                 <!-- text input -->
                <div class="form-group col-md-4">
                  <label>Key <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_key[]">
                </div>
                <div class="form-group col-md-4">
                  <label>Tiếng Việt <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_vi[]" >
                </div>  
                <div class="form-group col-md-4">
                  <label>English <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="text_en[]" >
                </div>                
               </div> 
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-default" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary" id="btnSave">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('text.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
      <!--/.col (left) -->      
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
      $('#formData').submit(function(){
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
    });
    
</script>
@stop
