<!-- letest product section -->
<section class="top-letest-product-section">
    <div class="container">
        <div class="section-title">
            <h2>LATEST PRODUCTS</h2>
        </div>
        <div class="product-slider owl-carousel">
            @foreach ($public_product->slice(0,5)->all() as $homepage_public)
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
                        <a href="{{ route('filters', ['type' => 'love', 'slug' => $homepage_public->item_product_id]) }}"
                            class="wishlist-btn"><i class="fa fa-heart{{ array_key_exists($homepage_public->item_product_id, $whitelist) ? '' : '-o' }}"
                                aria-hidden="true"></i>
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
            @endforeach
        </div>
    </div>
</section>
<!-- letest product section end -->