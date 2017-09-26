<div class="col-md-3 col-sm-4 col-xs-12 sidebar">
  <div class="sidebar-shop sidebar-left">    
    @if($lienquanArr->count() > 0)
    <div class="widget widget-related-product">
      <h2 class="widget-title">Sản phẩm liên quan</h2>
      <ul class="list-product-related">
        @foreach($lienquanArr as $product)
        <li class="clearfix">
          <div class="product-related-thumb">
            <a href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->product_id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->product_id]) }}"><img src="{{ Helper::showImage($product->image_url) }}" alt="{!! $lang == 'vi' ? $product->name_vi : $product->name_en !!}" /></a>
          </div>
          <div class="product-related-info">
            <h3 class="title-product"><a href="{{ $lang == 'vi' ? route('chi-tiet-vi',['slug' => $product->slug_vi, 'id' => $product->product_id]) : route('chi-tiet-en', ['slug' => $product->slug_en, 'id' => $product->product_id]) }}">{!! $lang == 'vi' ? $product->name_vi : $product->name_en !!}</a></h3>
            <div class="info-price">
              @if($product->is_sale == 1 && $product->price_sale > 0)
                <span>{{ number_format($product->price_sale) }}$</span>
                <del>{{ number_format($product->price) }}$</del>
              @else
                  @if($lang == 'en' && $product->price_vnd > 0)
                  <span>{{ $product->price > 0 ? number_format($product->price)."$" : "Liên hệ" }}</span><br>
                  <span>{{ $product->price_vnd > 0 ? number_format($product->price_vnd)." VND" : "Liên hệ" }}</span>
                  @else
                  <span>{{ $product->price_vnd > 0 ? number_format($product->price_vnd) : "Liên hệ" }}</span>
                  @endif
              @endif
            </div>           
          </div>
        </li>        
        @endforeach
      </ul>
    </div>
    @endif    
  </div>
  <!-- End Sidebar Shop -->
</div>