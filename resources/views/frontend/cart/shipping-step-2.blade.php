@extends('frontend.layout')
@include('frontend.partials.meta')
@section('content')
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
       
        <div class="page-content" style="margin-top:20px">
          <!-- row -->
          <div class="shipping-address-page">

                <div class="shipping-header">
                
                </div>

                <div class="row visible-lg-block">
                  <div class="col-lg-12">
                    <h3 style="font-size:15px">2. {{ trans('text.dia-chi-giao-hang') }}</h3>
                  </div>
                </div>

                <div class="row row-style-2">
                  <div class="col-md-8 has-padding">
                    <div class="panel panel-default address-list">
                      <div class="panel-body" style="padding:0px 0px">
                        <form id="form-address" method="post" action="">
                          <h5 class="visible-lg-block" style="margin-top:20px"> {{ trans('text.chon-dia-chi-giao-hang-co-san-ben-duoi') }}: </h5>                          
                          <div class="row row-address-list">
                            <div class="col-lg-6 col-md-6 col-sm-6 item">
                              <div class="panel panel-default address-item is-default">
                                <div class="panel-body">
                                
                                  <p class="name">{{ $customer->full_name }}</p>
                                  <p class="address">
                                    @if($customer->country_id == 235)
                                      @if( isset( $customer->tinh->name ))
                                        {{ $customer->tinh->name }},
                                      @endif
                                      @if( isset( $customer->huyen->name ) )
                                        {{ $customer->huyen->name }},
                                      @endif
                                      @if( isset($customer->xa->name ))
                                        {{ $customer->xa->name }},
                                      @endif
                                      @else
                                        @if( isset($customer->country->name ))
                                          {{ $customer->country->name }},
                                        @endif
                                      @endif
                                      {{$customer->address}}
                                  </p>
                                  <p class="phone">{{ trans('text.dien-thoai') }}: {{ $customer->phone }}</p>
                                 
                                  <p class="action">
                                    <button type="button" class="btn btn-default btn-custom1 saving-address is-red" onclick="location.href='{{route('shipping-step-3')}}'"> {{ trans('text.giao-den-dia-chi-nay') }} </button>
                                    <button type="button" class="btn btn-default btn-custom1 edit-address">{{ trans('text.sua') }}</button>
                                  </p>                                  
                                </div><!--panel-body-->
                            </div><!--panel panel-default address-item is-default-->
                          </div><!--col-lg-6 col-md-6 col-sm-6 item-->
                          </div><!--row row-address-list-->
                        </form>
                      </div>
                    </div>
                    <div class="panel panel-default address-form is-edit">
                      <div class="panel-heading hidden-lg">{{ trans('text.cap-nhat') }} địa chỉ giao hàng mới</div>
                      <div class="panel-body">
                        <form class="form-horizontal bv-form" role="form" id="address-info" novalidate> 
                          <input type="hidden" name="full_name" value="{{ $customer->full_name }}" id="full_name">
                          <input type="hidden" name="telephone" value="{{ $customer->facebook_id ? '0999999999' : $customer->phone }}" id="telephone">                         
                          <input type="hidden" name="country_id" value="235">
                         
                          <div class="form-group row viet">
                            <label for="city_id" class="col-lg-4 control-label visible-lg-block">{{ trans('text.tinh-thanh-pho') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="city_id" class="form-control address" id="city_id" data-bv-field="city_id">
                                <option value="">{{ trans('text.chon') }} {{ trans('text.tinh-thanh-pho') }}</option>
                                @foreach($listCity as $city)
                                  <option value="{{$city->id}}"
                                  @if($customer->city_id == $city->id || $city_default == $city->id)
                                  selected
                                  @endif
                                  >{{$city->name}}</option>
                                @endforeach
                              </select>
                              <small class="help-block" data-bv-validator="notEmpty" data-bv-for="city_id" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-chon') }} {{ trans('text.tinh-thanh-pho') }}</small></div>
                          </div>
                          <div class="form-group row viet">
                            <label for="district_id" class="col-lg-4 control-label visible-lg-block">{{ trans('text.quan-huyen') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="district_id" class="form-control address" id="district_id">
                                <option value="0">{{ trans('text.chon') }} {{ trans('text.quan-huyen') }}</option>                            
                              </select>
                               <small class="help-block" data-bv-validator="notEmpty" data-bv-for="district_id" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-chon') }} {{ trans('text.quan-huyen') }}</small></div>
                          </div>
                          <div class="form-group row viet">
                            <label for="ward_id" class="col-lg-4 control-label visible-lg-block">{{ trans('text.phuong-xa') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <select name="ward_id" class="form-control address" id="ward_id">
                                <option value="0">{{ trans('text.chon') }} {{ trans('text.phuong-xa') }}</option>
                              </select>
                               <small class="help-block" data-bv-validator="notEmpty" data-bv-for="ward_id" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-chon') }} {{ trans('text.phuong-xa') }}</small></div>
                          </div>
                          <div class="form-group row">
                            <label for="street" class="col-lg-4 control-label visible-lg-block">{{ trans('text.dia-chi') }}</label>
                            <div class="col-lg-8 input-wrap has-feedback">
                              <textarea name="street" class="form-control address" id="street" placeholder="Ví dụ: 52, đường Trần Hưng Đạo" data-bv-field="street" style="height:100px">{{ $customer->address }}</textarea>
                               <small class="help-block" data-bv-validator="notEmpty" data-bv-for="street" data-bv-result="NOT_VALIDATED" style="display: none;">{{ trans('text.vui-long-nhap') }} {{ trans('text.dia-chi') }}</small></div>
                          </div>
                          <input type="hidden" name="delivery_address_type" value="1">
                          
                          <div class="form-group row end">
                            <div class="col-lg-offset-4 col-lg-8">
                              @if(!Session::has('new-register'))
                              <button type="button" class="btn btn-default btn-custom2 visible-lg-inline-block js-hide">{{ trans('text.huy') }}</button>
                              @endif
                              <div id="btn-address" class="btn btn-primary btn-custom3" value="update">{{ trans('text.cap-nhat') }}</div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="shiping_plan"></div>
                  </div>
                  <div class="col-md-4">
                    @include('frontend.cart.blocks.panel-cart')
                  </div>
                </div>

           </div><!-- /.shipping-address-page -->

        </div><!-- /.page-content -->
    </div>
</div>
@endsection
@section('javascript')
   <script type="text/javascript">
    $(document).ready(function() {
      $('div.viet').show();
      var customer_district_id = '{{ $customer->district_id }}';
      var customer_ward_id = '{{ $customer->ward_id }}';
      var customer_country_id = 235;
      if(customer_country_id == 235){
        $('div.viet').show();
      }else{
        $('div.viet').hide();
      }
      $('.edit-address').click(function() {
        $('.address-form').show();
      });
   

      @if(Session::has('new-register') || Session::has('register') ||
         !$customer->full_name ||         
         !$customer->address ||
         !$customer->phone ||
         !$customer->country_id ||
         ( $customer->country_id == 235 && ( !$customer->district_id || !$customer->city_id || !$customer->ward_id )
        ))        
        $('.address-form').show();
        $('#form-address').hide();
      @endif
      

      $('#btn-address').click(function() {
        $(this).attr('disabled', '');
        validateData();
      });

      function validateData() {
        var error = [];

        var full_name = $('#full_name').val();
        var city_id   = $('#city_id').val();
        var country_id   = 235;
        var district_id   = +$('#district_id').val();
        var ward_id   = +$('#ward_id').val();
        var street    = $('#street').val();
        var telephone = $('#telephone').val();
        var email = $('#email_form').val();

        if(!full_name.length)
        {
          error.push('full_name');
        }
        if(!country_id)
        {
          error.push('country_id');
        }
        if(country_id == 235){
          if(!city_id)
          {
            error.push('city_id');
          }

          if(!district_id)
          {
            error.push('district_id');
          }

          if(!ward_id)
          {
            error.push('ward_id');
          }
        }        

        if(!street)
        {
          error.push('street');
        }
        //alert(validateEmail(email));
        if(!(/\d{8,15}$/g.test(telephone))) {
          error.push('telephone');
        }
        
        if((!telephone)){
          error.push('email_form'); 
        }


        var list = ['full_name', 'city_id', 'district_id', 'ward_id', 'street', 'telephone' ];

        for( i in list ) {
            $('#' + list[i]).next().hide();
            $('#' + list[i]).parent().removeClass('has-error');
        }

        if(error.length) {
          for( i in error ) {
            $('#' + error[i]).parent().addClass('has-error');
            $('#' + error[i]).next().show();
          }

          $('#btn-address').removeAttr('disabled');
        } else {
          $.ajax({
            url: "{{ route('update-customer') }}",
            method: "POST",
            data : {
              full_name : full_name,
              city_id : city_id,
              district_id : district_id,
              country_id : 235,
              ward_id : ward_id,
              address : street,
              phone : telephone,
              address_type : 1
            },
            success : function(data){
              location.reload();
            }
          });
        }
      }

      $('.js-hide').click(function() {
        $('.address-form').hide();
      });
      
      $('#city_id').change(function() {
        customer_district_id = 0;
        getDistrict($(this).val());
      });
      if( $('#city_id').val() > 0){
        getDistrict($('#city_id').val());
      }

      $('#district_id').change(function() {       
        customer_ward_id = 0;
        getWard($(this).val());
      });
      if( $('#district_id').val() > 0){
        getWard($('#district_id').val());
      }
      function validateEmail(email) {
          var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
      }
      function getDistrict(city_id) {

        if(!city_id) {
          $('#district_id').empty();
          $('#district_id').append('<option value="0">{{ trans('text.chon') }} {{ trans('text.quan-huyen') }}</option>');
          return;
        }

        $.ajax({
          url: "{{ route('get-district') }}",
          method: "POST",
          data : {
            id: city_id
          },
          success : function(list_ward){
            $('#district_id').empty();
            $('#district_id').append('<option value="0">{{ trans('text.chon') }} {{ trans('text.quan-huyen') }}</option>');

            for(i in list_ward) {
              $('#district_id').append('<option value="'+list_ward[i].id+'">'+list_ward[i].name+'</option>');
            }
            if( customer_district_id > 0){
              $('#district_id').val(customer_district_id);
              getWard(customer_district_id);
            }

          }
        });
      }
      function getWard(district_id) {

        if(!district_id) {
          $('#ward_id').html('<option value="0">{{ trans('text.chon') }} {{ trans('text.phuong-xa') }}</option>');
          return;
        }

        $.ajax({
          url: "{{route('get-ward')}}",
          method: "POST",
          data : {
            id: district_id
          },
          success : function(list_ward){
            $('#ward_id').empty();
            $('#ward_id').append('<option value="0">{{ trans('text.chon') }} {{ trans('text.phuong-xa') }}</option>');

            for(i in list_ward) {
              $('#ward_id').append('<option value="'+list_ward[i].id+'">'+list_ward[i].name+'</option>');
            }            
            $('#ward_id').val(customer_ward_id);

          }
        });
      }

    });
  </script>
@endsection








