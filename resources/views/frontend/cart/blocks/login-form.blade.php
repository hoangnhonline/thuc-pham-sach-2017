<div id="login-form" class="member-form">
  <form class="content bv-form" method="POST"
  action="{{route('auth-login')}}" novalidate>
    {{csrf_field()}}
    @if(Session::has('error'))
      <div class="alert alert-danger">
          {{ Session::get('error') }}
      </div>
    @endif
    <button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
    <input type="hidden" name="checkout_step" value="1">
    <div class="form-group has-feedback" id="popup_login">
      <label class="control-label">Số ĐT</label>
      <input id="login_phone" type="text" class="form-control login" name="phone" placeholder="Nhập Số ĐT" data-bv-field="phone">  
      <small class="help-block" data-bv-validator="notEmpty" data-bv-for="phone" data-bv-result="INVALID" style="display:none">Vui lòng nhập Số ĐT</small><small class="help-block" data-bv-validator="regexp" data-bv-for="phone" data-bv-result="VALID" style="display: none;">Số ĐT không hợp lệ</small></div>
    <div class="form-group has-feedback" id="popup_password">
      <label class="control-label">{{ trans('text.mat-khau') }}</label>
      <input type="password" id="login_password" class="form-control login" name="password" placeholder="Nhập mật khẩu" autocomplete="off" data-bv-field="password">
     <small class="help-block" data-bv-validator="notEmpty" data-bv-for="password" data-bv-result="NOT_VALIDATED" style="display: none;">Vui lòng nhập Mật khẩu</small></div>
    <div class="login-ajax-captcha" style="display:none">
      <div id="login-checkout-recaptcha"></div>
      <span class="help-block ajax-message"></span> </div>
    <div class="form-group" id="error_captcha" style="margin-bottom: 15px;color:red;font-style:italic"> <span class="help-block ajax-message"></span> </div>
    <div class="form-group last">
      {{-- <p class="reset">Quên mật khẩu? Khôi phục mật khẩu <a data-toggle="modal" data-target="#reset-password-form" href="javascript:(void);" class="link">tại đây</a></p> --}}
      <button type="submit" id="login_popup_submit_1" class="btn btn-info btn-block btn-member">{{ trans('text.dang-nhap') }}</button>
    </div>
  </form>
</div><!--login form-->
<!-- login widget -->