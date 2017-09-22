@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Block Footer   
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('footer.index') }}">Block Footer</a></li>
      <li class="active">Chỉnh sửa</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default" href="{{ route('footer.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('footer.update') }}">
    <div class="row">
      <!-- left column -->
      <input name="id" value="{{ $detail->id }}" type="hidden">
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
                                           
                
                <div class="form-group" >
                  
                  <label>Tên VI<span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="name_vi"  rows="10" id="name_vi" value="{{ $detail->name_vi }}">
                </div> 
                <div class="form-group" >
                  
                  <label>Nội dung VI<span class="red-star">*</span></label>
                  <textarea class="form-control" name="content_vi">{{ $detail->content_vi }}</textarea>
                </div> 
                <!--<div class="form-group" >
                  
                  <label>Tên EN<span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="name_en" id="name_en" value="{{ $detail->name_en }}">
                </div> 
                <div class="form-group" >
                  
                  <label>Nội dung EN<span class="red-star">*</span></label>
                  <textarea class="form-control" name="content_en" rows="10">{{ $detail->content_en }}</textarea>
                </div>                   -->
            </div>                      
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="{{ route('footer.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>         
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
      var editor2 = CKEDITOR.replace( 'content_vi',{
          language : 'vi',
          height : 200,
          allowedContent: true
      });
     
      CKEDITOR.dtd.$removeEmpty.i = 0;
    });

</script>
@stop