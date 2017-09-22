<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi">
    <head>
        <title>@yield('title')</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="robots" content="index,follow"/>
        <meta http-equiv="content-language" content="en"/>
        <meta name="description" content="@yield('site_description')"/>
        <meta name="keywords" content="@yield('site_keywords')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
        <link rel="shortcut icon" href="@yield('favicon')" type="image/x-icon"/>
        <link rel="canonical" href="{{ url()->current() }}"/>        
        <meta property="og:locale" content="vi_VN" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:description" content="@yield('site_description')" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:site_name" content="shop.com" />
        <?php $socialImage = isset($socialImage) ? $socialImage : $settingArr['banner']; ?>
        <meta property="og:image" content="{{ Helper::showImage($socialImage) }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:description" content="@yield('site_description')" />
        <meta name="twitter:title" content="@yield('title')" />        
        <meta name="twitter:image" content="{{ Helper::showImage($socialImage) }}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/lib/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/lib/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/lib/select2/css/select2.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/lib/jquery.bxslider/jquery.bxslider.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/lib/owl.carousel/owl.carousel.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/lib/jquery-ui/jquery-ui.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/reset.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/responsive.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/custom.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('public/assets/css/sweetalert2.min.css') }}">
        <link href="{{ URL::asset('public/assets/css/square/red.css') }}" rel="stylesheet">
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ $settingArr['google_analystic'] }}', 'auto');
        ga('send', 'pageview');

        </script>
    </head>
    <body {{ \Request::route()->getName() == "home" ? "class=home" : "" }}>   
        @yield('header')
        @yield('slider')
        @yield('content')
        @yield('footer')
      <!-- Modal -->
            <div class="modal fade" id="modalLoginFrom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Đăng nhập</h4>
                    <div class="head">
                      <p> <span>Bạn chưa có tài khoản? </span> <a href="javascript:(void);" class="link" data-dismiss="modal" data-toggle="modal" data-target="#modalRegisterFrom">Đăng ký</a> </p>
                    </div>
                  </div>
                  <div class="modal-body">

                      <form method="POST" action="#" id="login_popup_form">
                        <div class="form-group popup_email has-feedback" id="popup_login">
                          <label class="control-label">Email</label>
                          <input data-bv-field="email" id="popup-login-email" class="form-control login" name="email" placeholder="Nhập Email" type="text">
                          <small data-bv-result="NOT_VALIDATED" data-bv-for="email" data-bv-validator="notEmpty" class="help-block" style="display: none;">Vui lòng nhập Email hợp lệ</small></div>
                        <div class="form-group popup_password has-feedback" id="popup_password">
                          <label class="control-label">Mật khẩu</label>
                          <input data-bv-field="password" id="popup-login-password" class="form-control login" name="password" placeholder="Nhập mật khẩu" autocomplete="off" type="password">
                           <small data-bv-result="NOT_VALIDATED" data-bv-for="password" data-bv-validator="notEmpty" class="help-block" style="display: none;">Vui lòng nhập Mật khẩu</small></div>
                        <div class="login-ajax-captcha" style="display:none">
                          <div id="login-popup-recaptcha"></div>
                        </div>
                        <div class="form-group" id="error_captcha" style="margin-bottom: 15px;color:red;font-style:italic"> <span class="help-block ajax-message"></span> </div>
                        <div class="form-group">
                          <p class="reset">Quên mật khẩu? Nhấn vào <a href="javascript:(void);" class="link" data-dismiss="modal" data-toggle="modal" data-target="#modalResetPasswordFrom">đây</a></p>
                        </div>
                        <div class="form-group">
                          <div  id="login_popup_submit" class="btn btn-danger btn-block">Đăng nhập</div>
                        </div>
                        <div class="form-group last"> <a class="btn btn-block btn-social btn-facebook user-name-loginfb login-by-facebook-popup" title="Đăng nhập bằng Facebook" data-url=""> <i class="fa fa-facebook"></i> <span>Đăng nhập bằng</span><span> Facebook</span> </a> </div>
                      </form>
                  </div><!-- end modal-body -->
                </div>
              </div><!-- end modal-dialog -->
            </div><!-- end modal -->

            <!-- Modal -->
            <div class="modal fade" id="modalRegisterFrom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Đăng ký tài khoản</h4>
                    <div class="head">
                      <p> <span>Bạn đã có tài khoản?</span> <a href="javascript:(void);" class="link" data-dismiss="modal" data-toggle="modal" data-target="#modalLoginFrom">Đăng nhập</a> </p>
                    </div>
                  </div>
                  <div class="modal-body">

                      <form method="POST" action="#" id="register_popup_form" class="row">
                        <div class="col-sm-6">
                          <div class="form-group" id="register_email">
                            <label class="control-label" for="email"><strong>Email:</strong></label>
                            <div class="input-wrap has-feedback">
                              <input data-bv-field="email" class="form-control register register-email-input" name="email" id="popup-register-email" placeholder="Nhập Email" type="text">
                              <small data-bv-result="NOT_VALIDATED" data-bv-for="email" er="notEmpty" class="help-block" style="display: none;">Vui lòng nhập Email</small><small er="NOT_VALIDATED" data-bv-for="email" data-bv-validator="remote" class="help-block" style="display: none;">Email đã tồn tại</small></div>
                          </div>
                          <div class="form-group" id="register_password">
                            <label class="control-label" for="pasword"><strong>Mật khẩu:</strong></label>
                            <div class="input-wrap has-feedback">
                              <input data-bv-field="password" class="form-control register" name="password" id="popup-register-password" placeholder="Mật khẩu từ 6 đến 32 ký tự" autocomplete="off" type="password">
                              <small data-bv-result="NOT_VALIDATED" data-bv-for="password" data-bv-validator="notEmpty" class="help-block" style="display: none;">Vui lòng nhập Mật khẩu</small><small data-bv-result="NOT_VALIDATED" data-bv-for="password" data-bv-validator="stringLength" class="help-block" style="display: none;">Mật khẩu phải dài từ 6 đến 32 ký tự</small></div>
                          </div>
                          <div class="form-group" id="register_name">
                            <label class="control-label">Họ tên</label>
                            <div class="input-wrap has-feedback">
                              <input class="form-control register" name="full_name" id="popup-register-name" placeholder="Nhập họ tên" data-bv-field="full_name" type="text">
                               <small class="help-block" data-bv-validator="notEmpty" data-bv-for="full_name" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng nhập Họ tên</small></div>
                          </div>
                          <div class="form-group">
                              <label class="checkbox-inline" style="padding-left:0px">
                                <input type="checkbox"> Nhận các thông tin và chương trình khuyến mãi của shop.com qua email.
                              </label>
                          </div>
                          <div class="form-group policy-group">
                            <div class="input-wrap">
                              <p class="policy">Khi bạn nhấn Đăng ký, bạn  đã đồng ý thực hiện mọi giao dịch mua bán theo <a target="_blank" href="#">điều kiện sử dụng và chính sách của shop.com</a>.</p>
                            </div>
                          </div>
                          <div class="form-group last">
                            <div class="input-wrap">
                              <div id="register_popup_submit" class="btn btn-danger btn-block btn-register-submit">Đăng ký</div>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <p class="text" style="margin-bottom:5px">Đăng nhập vào shop.com bằng facebook</p>
                          <div class="form-group last"> <a class="btn btn-block btn-social btn-facebook user-name-loginfb login-by-facebook-popup" title="Đăng nhập bằng Facebook" data-url="#"> <i class="fa fa-facebook"></i> <span>Đăng nhập bằng</span><span> Facebook</span> </a> </div>
                        </div>
                      </form>

                  </div><!-- end modal-body -->
                </div>
              </div><!-- end modal-dialog -->
            </div><!-- end modal -->

            <!-- Modal -->
            <div class="modal fade" id="modalResetPasswordFrom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Quên mật khẩu?</h4>
                    <div class="head">
                      <p><span style="font-size:13px">Vui lòng gửi email. Chúng tôi sẽ gửi link khởi tạo mật khẩu mới qua email của bạn.</span></p>
                    </div>
                  </div>
                  <div class="modal-body" id="body_reset_pass">
                      <div id="forgot_successful" class="alert alert-success" style="display:none">
                        <span>Email đã được gửi, vui lòng kiểm tra mail để cập nhật thông tin!</span>
                    </div>                        
                        <div class="form-group" id="forgot_pass">
                          <input name="email_reset" id="email_reset" class="form-control" value="" required="required" placeholder="Nhập email" type="email">
                          <small class="help-block" id="error_reset"></small>
                        </div>
                        <div class="form-group last">
                          <button type="button" id="btnForgotPass" class="btn btn-danger btn-block">Gửi</button>
                        </div>
                      

                  </div><!-- end modal-body -->
                </div>
              </div><!-- end modal-dialog -->
            </div><!-- end modal -->  
      <!--<a href="#" class="scroll_top" title="Scroll to Top" style="display: inline;">Scroll</a>-->
      <!-- Script-->
      <input type="hidden" id="route-ajax-login-fb" value="{{route('ajax-login-by-fb')}}">
      <input type="hidden" id="route-cap-nhat-thong-tin" value="{{ route('cap-nhat-thong-tin') }}">
      <input type="hidden" id="fb-app-id" value="{{ env('FACEBOOK_APP_ID') }}">
      <input type="hidden" id="route-register-customer-ajax" value="{{ route('register-customer-ajax') }}">
      <input type="hidden" id="route-register-newsletter" value="{{ route('register.newsletter') }}">
      <input type="hidden" id="route-add-to-cart" value="{{ route('them-sanpham') }}" />
      <input type="hidden" id="route-cart" value="{{ route('gio-hang') }}" />

      <input type="hidden" id="route-auth-login-ajax" value="{{ route('auth-login-ajax') }}">
      <script type="text/javascript" src="{{ URL::asset('public/assets/lib/jquery/jquery-1.11.2.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('public/assets/lib/bootstrap/js/bootstrap.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('public/assets/lib/select2/js/select2.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('public/assets/lib/jquery.bxslider/jquery.bxslider.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('public/assets/lib/owl.carousel/owl.carousel.min.js') }}"></script>
      @if(\Request::route()->getName() == "chi-tiet")
      <script type="text/javascript" src="{{ URL::asset('public/assets/lib/jquery.elevatezoom.js') }}"></script>
      @endif
      <script type="text/javascript" src="{{ URL::asset('public/assets/js/jquery.actual.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('public/assets/lib/jquery-ui/jquery-ui.min.js') }}"></script>
      <script src="{{ URL::asset('public/assets/js/sweetalert2.min.js') }}"></script>
      @if(\Request::route()->getName() == "chi-tiet")
      <script type="text/javascript" src="{{ URL::asset('public/assets/lib/fancyBox/jquery.fancybox.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('public/assets/js/readmore.min.js') }}"></script>
      @endif
      <script src="{{ URL::asset('public/assets/js/icheck.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('public/assets/js/lazy.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('public/assets/js/theme-script.js') }}"></script>
      
      @if(\Request::route()->getName() == "home")
      <script type="text/javascript">
          $(document).ready(function(){
              $.ajax({
                type: "GET",
                url: '{{ route("load-slider")}}',              
                success: function(data) {
                    $('#home-slider').html(data);
                    var slider = $('#contenhomeslider').bxSlider(
                        {
                            nextText:'<i class="fa fa-angle-right"></i>',
                            prevText:'<i class="fa fa-angle-left"></i>',
                            auto: true,
                        }

                    );
                    
                }              
              });
              @if(Session::get('userId') > 0)
              $.ajax({
                type: "GET",
                url: '{{ route("count-message")}}',              
                success: function(count) {
                    if(parseInt(count) > 0){
                      $('#countNoti').html(count).show();
                    }
                }              
              });              
              @endif

          });

      </script>
      @endif  
      <script type="text/javascript">
        $(document).on('keypress', '#email_reset', function(e) {
          if(e.which == 13) {
              $('#btnForgotPass').click();
          }
      });
        $(document).ready(function(){

          $('#btnForgotPass').click(function(){
            $.ajax({
              url  : '{{ route('forget-password') }}',
              type : 'POST',
              data : {
                email_reset : $('#email_reset').val()
              },
              beforeSend : function(){
                $('#btnForgotPass').attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i>');
              },
              success : function(data){
                $('#forgot_pass').removeClass('has-error').hide();
                $('#error_reset').html('');        
                $('#btnForgotPass').hide();        
                $('#forgot_successful').show();                
              },
              error : function(res){
                $('#forgot_pass').addClass('has-error');
                $('#error_reset').html(res.responseJSON.email_reset[0]);                
                $('#btnForgotPass').removeAttr('disabled').html('Gửi');
              }
            })
          });
        });
      </script>
      @yield('javascript')      
      
       <!-- Hỗ trơ trực tuyến Facebook -->
  <div class="contact-face noprint" style="">
          <div class="title_quancaog" style="background: #d0021b;color: #fff;padding: 3px 10px;cursor:pointer;">
          <p class="xclose" style="display: none;margin: 0;" onclick="closeface();"><i class="fa fa-minus" aria-hidden="true" style="margin-right: 10px;"></i>Hỗ trợ trực tuyến</p>
          <p class="xopen" style="margin: 0;" onclick="openface();"><i class="fa fa-envelope-o" style="margin-right: 10px;" aria-hidden="true"></i>Để lại lời nhắn</p>
      </div>
      <div class="fb-page" data-tabs="messages" data-href="https://www.facebook.com/www.icho.vn" data-width="320px" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
          <div class="fb-xfbml-parse-ignore">
              <blockquote cite="https://www.facebook.com/www.icho.vn">
                  <a href="https://www.facebook.com/www.icho.vn">shop.com</a>
              </blockquote>
          </div>
      </div>
  </div>
  </body>
</html>
