<!-- Product filter section -->
<section class="product-filter-section">
    <div class="container">
        <div class="section-title">
            <h2>BROWSE TOP SELLING PRODUCTS</h2>
        </div>
        <ul class="product-filter-menu text-center">
            @isset($public_category)
            @foreach ($public_category as $home_category)
            <li>
                <a href="{{ route('filters', ['type' => 'category', 'slug' => $home_category->item_category_slug]) }}">
                    {{ strtoupper($home_category->item_category_name) }}
                </a>
            </li>
            @endforeach
            @endisset
        </ul>
        <div class="row">
            @foreach ($public_product->sortByDesc('item_product_counter')->slice(0,8)->all() as $homepage_public)
            <div class="col-lg-3 col-sm-6">
                <div class="product-item">
                    <div class="pi-pic">
                        @if($homepage_public->item_product_flag)
                        <div class="tag-sale">{{ $homepage_public->item_product_flag }}</div>
                        @endif
                        <a href="{{ route('single_product', ['slug' => $homepage_public->item_product_slug]) }}">
                            <img src="{{ Helper::files('product/'.$homepage_public->item_product_image) }}"
                                alt="{{ $homepage_public->item_product_name }}">
                        </a>
                        <div class="pi-links">
                            @auth
                            <a href="{{ route('filters', ['type' => 'love', 'slug' => $homepage_public->item_product_id]) }}" class="wishlist-btn">
                            <i class="fa fa-heart{{ array_key_exists($homepage_public->item_product_id, $whitelist) ? '' : '-o' }}" aria-hidden="true"></i>
                            </a>
                            @endauth
                        </div>
                    </div>
                    <a href="{{ route('single_product', ['slug' => $homepage_public->item_product_slug]) }}">
                        <div class="pi-text">
                            <h6>{{ number_format($homepage_public->item_product_sell) }}</h6>
                            <p>{{ $homepage_public->item_product_name }}</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center pt-5">
            <a href="{{ route('shop') }}" class="site-btn sb-line sb-dark">LOAD MORE</a>
        </div>
    </div>
</section>
<!-- Product filter section end -->