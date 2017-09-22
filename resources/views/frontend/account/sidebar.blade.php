<div class="col-md-3 col-sm-4 col-xs-12 sidebar">
  <div class="sidebar-shop sidebar-left">
    <div class="widget widget-filter">
      <div class="box-filter category-filter">
        <h2 class="widget-title">{{ trans('text.tai-khoan') }}</h2>
        <ul>
            <li {{ \Request::route()->getName() == "account-info" ? "class=active" : "" }}>
                <a href="{{ route('account-info') }}" title="Cập nhật thông tin"> {{ trans('text.cap-nhat-thong-tin') }}</a>
            </li>
            <li {{ \Request::route()->getName() == "order-history" || \Request::route()->getName() == "order-detail" ? "class=active" : "" }}>
                <a href="{{ route('order-history') }}" title="Đơn hàng của tôi"> {{ trans('text.don-hang-cua-toi') }}</a>
            </li>            
            @if(Session::get('facebook_id') == null)
            <li {{ \Request::route()->getName() == "change-password" ? "class=active" : "" }}>
                <a href="{{ route('change-password') }}" title="Đổi mật khẩu"> {{ trans('text.doi-mat-khau') }}</a>
            </li>
            @endif
            <li>
                <a href="{{ route('user-logout') }}" title="Thoát tài khoản"> {{ trans('text.thoat-tai-khoan') }} </a>
            </li>   
        </ul>
      </div>
    </div>  
  </div>
  <!-- End Sidebar Shop -->
</div>