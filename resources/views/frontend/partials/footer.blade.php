<div id="footer">
    <div class="footer5 footer11">
      <div class="container">
        <div class="footer-top footer-top5">
          <div class="logo-footer">
            <a href="{{ route('home') }}"><img alt="Logo TPS" src="{{ Helper::showImage($settingArr['logo']) }}" height="45px"></a>
          </div>
          <div class="menu-footer">
            <ul>
              <li>
                <a href="{{ route('home') }}" title="{{ trans('text.trang-chu') }}">{!! trans('text.trang-chu') !!}</a>
              </li>
              <li>
                <a href="{{ route('pages', 'gioi-thieu') }}" title="Giới thiệu">Giới thiệu</a>                
              </li>   
              @foreach($loaiSpList as $loaiSp)              
              <li>
                <a title="{!! $lang == 'vi' ? $loaiSp->name_vi : $loaiSp->name_en !!}" href="{{ $lang == 'vi' ? route('danh-muc-cha', [$loaiSp->slug_vi]) : route('danh-muc-cha', [$loaiSp->slug_en]) }}">{!! $lang == 'vi' ? $loaiSp->name_vi : $loaiSp->name_en !!}</a>                
              </li>
              @endforeach  
              <li><a href="{{ $lang == 'vi' ? route('album-vi') : route('album-en') }}" >Hình ảnh</a></li> 
              <li><a href="{{ route('video') }}">Video</a></li>    
              <li>
                <a href="{{ route('news-vi') }}">Tin tức</a>                
              </li>            
            </ul>
          </div>
        </div>        
        <!-- End Online Shipping -->
        <div class="list-footer-box5">
          <div class="row">
            @foreach($footerArr as $footer)
            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="footer-box">
                <h2>{!! $lang == 'vi' ? $footer->name_vi : $footer->name_en !!}</h2>
                {!! $lang == 'vi' ? $footer->content_vi  : $footer->content_en !!}
              </div>
            </div>
            @endforeach            
          </div>
        </div>
        <!-- End List Box -->
        <div class="footer-bottom5">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <ul>
                <li>
                  <span class=" fa fa-bar-chart"></span>&nbsp;Hôm nay: <strong style="color:#28AA4A">{{ number_format($counter['day']) }}</strong>
                </li>
                <li>
                  <span class=" fa fa-bar-chart"></span>&nbsp;Tổng truy cập: <strong style="color:#28AA4A">{{ number_format($counter['all']) }}</strong>
                </li>
              </ul>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="copyright" style="text-align:right">
                <p>All Rights Reserved. Powered by <a href="http://sahoweb.com" target="_blank">sahoweb.com</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Footer -->
