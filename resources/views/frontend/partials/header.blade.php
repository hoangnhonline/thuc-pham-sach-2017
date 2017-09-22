<?php 
$loaiSpList = DB::table('loai_sp')->where('status', 1)->orderBy('display_order')->get();
?>
<div id="header">
  <div class="header3 header5 header11" style="padding:5px;padding-bottom:10px">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
          <div class="logo5">
            <a href="{{ route('home') }}"><img src="{{ Helper::showImage($settingArr['logo']) }}" alt="Logo TPS" height="80px" /></a>
          </div>
        </div>
       
        <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top:20px">
          <div class="smart-search search-form3 search-form5">
            
            <form class="smart-search-form" method="GET" action="{{ route('search') }}">
              <input type="text"  name="keyword" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue" value="{{ isset($tu_khoa) ? $tu_khoa : trans('text.nhap-ten-san-pham') }}" />
              <input type="submit" value="" />
            </form>
          </div>
        </div>
         <div class="col-md-2 col-sm-2 col-xs-12">
          <p style="color:#FFF; padding-top:25px;font-size:17px">Mr.Tiến 094-909-8118</p>
          <p style="color:#FFF; font-size:17px">Cuộc sống an lành</p>
        </div>
        <div class="col-md-3 col-sm-4  col-xs-12"  style="padding-top:20px">
          <div class="wrap-cart-info3">
            <ul class="top-info top-info3">
              <li class="top-account has-child">
                @if(!Session::get('login'))
                <a href="#"><i class="fa fa-user"></i></a>
                <ul class="user-ajax-guest sub-menu-top">
                    <li id="login_link"><a class="user-name-login" title="Đăng Nhập" href="javascript:(void);" class="link" data-dismiss="modal" data-toggle="modal" data-target="#modalLoginFrom"><i class="fa fa-sign-in"></i> {{ trans('text.dang-nhap') }}</a></li>
                    <li id="login_fb_link" class="login-by-facebook-popup">
                    <a data-url="#" title="Đăng nhập bằng Facebook" class="user-name-loginfb"><i class="fa fa-facebook-square"></i>{{ trans('text.dang-nhap-bang-facebook') }}</a>
                    </li>
                    <li class="user-name-register">
                      <a title="Tạo tài khoản mới" class="link" data-dismiss="modal" data-toggle="modal" data-target="#modalRegisterFrom"><i class="fa fa-user"></i><span>{{ trans('text.tao-tai-khoan') }}</span></a>
                    </li>
                </ul>
                @else
                @if(Session::get('facebook_id'))
                <div class="user-avatar" style="float:left"><img alt="{{Session::get('username')}}" data-original="{{ Session::get('avatar') != '' ? Session::get('avatar') :  URL::asset('public/assets/images/avatar-s.png') }}" height="40" width="40" class="lazy" style="border-radius:30px;margin-top:-10px"></div>
                @endif
                <a href="#">{{ trans('text.chao') }}, {{ Session::get('username') }}</a> 
                <ul class="sub-menu-top left">
                  <li> <a href="{{ route('account-info') }}" title="{{ trans('text.thong-tin-tai-khoan') }}"><i class="fa fa-user"></i> {{ trans('text.thong-tin-tai-khoan') }} </a> </li>
                  <li> <a href="{{ route('order-history') }}" title="{{ trans('text.don-hang-cua-toi') }}"><i class="fa fa-heart-o"></i> {{ trans('text.don-hang-cua-toi') }} </a> </li>                  
                  @if(Session::get('facebook_id') == null)
                  <li> <a href="{{ route('change-password') }}" title="{{ trans('text.doi-mat-khau') }}"><i class="fa fa-unlock-alt"></i> {{ trans('text.doi-mat-khau') }}</a> </li>
                  @endif
                  <li> <a href="{{route('user-logout')}}" title="{{ trans('text.thoat-tai-khoan') }}"><i class="fa fa-sign-in"></i> {{ trans('text.thoat-tai-khoan') }} </a> </li>                 
                </ul> 
                @endif
                

              </li>                          
            </ul>
            <div class="mini-cart mini-cart-3">
              <a class="header-mini-cart3 header-mini-cart5" href="{{ route('gio-hang') }}">
                <span class="total-mini-cart-icon"></span>
                <span class="total-mini-cart-item">{{Session::get('products') ? array_sum(Session::get('products')) : 0}}</span>
              </a>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Header 3 -->
  <div class="header-nav5">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">
          <nav class="main-nav main-nav5">
            <ul>
              <li>
                <a href="{{ route('home') }}" {{ \Request::route()->getName() == "home" ? "class=active" : "" }}>{{ trans('text.trang-chu') }}</a>                
              </li>              
              @foreach($loaiSpList as $loaiSp) 
              <?php 
              $loai_id = $loaiSp->id;
              $cateList = DB::table('cate')->where('loai_id', $loai_id)->orderBy('display_order')->get();
              
              ?>
              <li class="@if(!empty($cateList)) menu-item-has-children @endif">
                <a href="{{ $lang == 'vi' ? route('danh-muc-cha', [$loaiSp->slug_vi]) : route('danh-muc-cha', [$loaiSp->slug_en]) }}" {{ isset($rs) && $rs->id == $loaiSp->id ? "class=active" : "" }}>{{ $lang == 'vi' ? $loaiSp->name_vi : $loaiSp->name_en }}</a>
                @if(!empty($cateList))
                <ul class="sub-menu">
                  @foreach($cateList as $cate)
                  <li><a href="{{ $lang == 'vi' ? route('danh-muc-con', [$loaiSp->slug_vi, $cate->slug_vi]) : route('danh-muc-con', [$loaiSp->slug_en, $cate->slug_en]) }}">{{ $lang == 'vi' ? $cate->name_vi : $cate->name_en }}</a></li>                  
                  @endforeach
                </ul>
                @endif
              </li>
              @endforeach
              <li>
                <a href="{{ route('news-vi') }}" {{ \Request::route()->getName() == "news-vi" || \Request::route()->getName() == "news-detail-vi" ? "class=active" : "" }}>Tin tức</a>                
              </li>   
            </ul>
            <a href="#" class="toggle-mobile-menu"><span> </span></a>
          </nav>
          <!-- End Main Nav -->
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 hidden-xs hidden-sm">
          <div class="category-dropdown hidden-dropdown right-category-dropdown">
            <h2 class="title-category-dropdown"><span>{{ trans('text.danh-muc') }}</span></h2>
            <div class="wrap-category-dropdown">
              <ul class="list-category-dropdown">
                @foreach($loaiSpList as $loaiSp) 
                <?php 
                $loai_id = $loaiSp->id;
                $cateList = DB::table('cate')->where('loai_id', $loai_id)->orderBy('display_order')->get();
                
                ?>
                <li class="@if(!empty($cateList)) has-cat-mega @endif">
                  <a href="{{ $lang == 'vi' ? route('danh-muc-cha', [$loaiSp->slug_vi]) : route('danh-muc-cha', [$loaiSp->slug_en]) }}">{{ $lang == 'vi' ? $loaiSp->name_vi : $loaiSp->name_en }}</a>               
                  @if(!empty($cateList))
                  <div class="cat-mega-menu cat-mega-style1" style="width:300px">
                    <div class="row">
                      <div class="col-md-12 col-sm-3">
                        <div class="list-cat-mega-menu">
                          @foreach($cateList as $cate)
                          <h2 class="title-cat-mega-menu"><a href="{{ $lang == 'vi' ? route('danh-muc-con', [$loaiSp->slug_vi, $cate->slug_vi]) : route('danh-muc-con', [$loaiSp->slug_en, $cate->slug_en]) }}">{{ $lang == 'vi' ? $cate->name_vi : $cate->name_en }}</a></h2>
                          @endforeach
                        </div>
                      </div> 
                    </div>
                  </div> 
                  @endif
                </li>                
                @endforeach
              </ul>
              <a class="expand-category-link" href="#"></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Main Nav -->
</div>  