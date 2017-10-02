<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ URL::asset('public/admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->full_name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="treeview {{ in_array(\Request::route()->getName(), ['product.index', 'product.create', 'product.edit', 'loai-sp.index', 'loai-sp.edit', 'loai-sp.create', 'cate.index', 'cate.edit', 'cate.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-opencart"></i> 
          <span>Sản phẩm</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['product.index', 'product.edit']) ? "class=active" : "" }}><a href="{{ route('product.index') }}"><i class="fa fa-circle-o"></i> Sản phẩm</a></li>
          <li {{ \Request::route()->getName() == "product.create" ? "class=active" : "" }}><a href="{{ route('product.create') }}"><i class="fa fa-circle-o"></i> Thêm sản phẩm</a></li>
          <li {{ in_array(\Request::route()->getName(), ['loai-sp.index', 'loai-sp.edit', 'loai-sp.create']) ? "class=active" : "" }}><a href="{{ route('loai-sp.index') }}"><i class="fa fa-circle-o"></i> Danh mục cha</a></li>
          <li {{ in_array(\Request::route()->getName(), ['cate.index', 'cate.edit', 'cate.create']) ? "class=active" : "" }}><a href="{{ route('cate.index') }}"><i class="fa fa-circle-o"></i> Danh mục con</a></li>
        </ul>
      </li>
      <li class="treeview {{ in_array(\Request::route()->getName(), ['album.index', 'album.create', 'album.edit']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-opencart"></i> 
          <span>Album ảnh</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['album.index', 'album.edit']) ? "class=active" : "" }}><a href="{{ route('album.index') }}"><i class="fa fa-circle-o"></i> Album ảnh</a></li>
          <li {{ \Request::route()->getName() == "album.create" ? "class=active" : "" }}><a href="{{ route('album.create') }}"><i class="fa fa-circle-o"></i> Thêm album ảnh</a></li>          
        </ul>
      </li>
      <li {{ in_array(\Request::route()->getName(), ['video.edit', 'video.index', 'video.create']) ? "class=active" : "" }}>
        <a href="{{ route('video.index') }}">
          <i class="fa fa-pencil-square-o"></i> 
          <span>Video</span>         
        </a>       
      </li>
      <li {{ in_array(\Request::route()->getName(), ['orders.index']) ? "class=active" : "" }}>
        <a href="{{ route('orders.index') }}">
          <i class="fa fa-pencil-square-o"></i> 
          <span>Đơn hàng</span>         
        </a>       
      </li>
      <li class="treeview {{ in_array(\Request::route()->getName(), ['articles.index', 'articles.create', 'articles.edit']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>Tin tức</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['articles.index', 'articles.edit']) ? "class=active" : "" }}><a href="{{ route('articles.index') }}"><i class="fa fa-circle-o"></i> Tin tức</a></li>
          <li {{ in_array(\Request::route()->getName(), ['articles.create']) ? "class=active" : "" }}><a href="{{ route('articles.create') }}"><i class="fa fa-circle-o"></i> Thêm tin tức</a></li>          
        </ul>
      </li>
      <li class="treeview {{ in_array(\Request::route()->getName(), ['pages.index', 'pages.create', 'pages.edit']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>Trang</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['pages.index', 'pages.edit']) ? "class=active" : "" }}><a href="{{ route('pages.index') }}"><i class="fa fa-circle-o"></i> Trang</a></li>
          <li {{ in_array(\Request::route()->getName(), ['pages.create']) ? "class=active" : "" }}><a href="{{ route('pages.create') }}"><i class="fa fa-circle-o"></i> Thêm trang</a></li>          
        </ul>
      </li> 
        
      <li {{ in_array(\Request::route()->getName(), ['newsletter.edit', 'newsletter.index']) ? "class=active" : "" }}>
        <a href="{{ route('newsletter.index') }}">
          <i class="fa fa-pencil-square-o"></i> 
          <span>Newsletter</span>         
        </a>       
      </li>
      <li {{ in_array(\Request::route()->getName(), ['contact.edit', 'contact.index']) ? "class=active" : "" }}>
        <a href="{{ route('contact.index') }}">
          <i class="fa fa-pencil-square-o"></i> 
          <span>Liên hệ</span>          
        </a>       
      </li>     
    
      <li class="treeview {{ in_array(\Request::route()->getName(), ['banner.index', 'banner.create', 'banner.edit', 'settings.index', 'info-seo.index', 'color.index', 'banner.list']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa  fa-gears"></i>
          <span>Cài đặt</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ \Request::route()->getName() == "settings.index" ? "class=active" : "" }}><a href="{{ route('settings.index') }}"><i class="fa fa-circle-o"></i> Thông tin shop.com</a></li>
          <li {{ \Request::route()->getName() == "color.index" ? "class=active" : "" }}><a href="{{ route('color.index') }}"><i class="fa fa-circle-o"></i> Color</a></li>
          <li {{ \Request::route()->getName() == "footer.index" ? "class=active" : "" }}><a href="{{ route('footer.index') }}"><i class="fa fa-circle-o"></i> Footer</a></li>
          <li {{ in_array(\Request::route()->getName(), ['banner.index', 'banner.create', 'banner.edit', 'banner.list']) ? 'class=active' : '' }}>
            <a href="{{ route('banner.list') }}"><i class="fa fa-circle-o"></i> Banner</a>
          </li>
          <!--<li>
            <a href="{{ route('banner.index', ['object_type' => 4 , 'object_id'=> 1 ] ) }}"><i class="fa fa-circle-o"></i> Đối tác</a>
          </li>-->
          <li {{ \Request::route()->getName() == "info-seo.index" ? "class=active" : "" }}><a href="{{ route('info-seo.index') }}"><i class="fa fa-circle-o"></i> Cài đặt SEO</a></li>   
        </ul>
      </li>
      <!--<li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<style type="text/css">
  .skin-blue .sidebar-menu>li>.treeview-menu{
    padding-left: 15px !important;
  }
</style>