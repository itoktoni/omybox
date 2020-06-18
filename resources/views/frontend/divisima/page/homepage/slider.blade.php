<!-- Hero section -->
<section class="hero-section">
    <div class="hero-slider owl-carousel">
        @foreach ($slider as $item_slider)
        <div class="hs-item set-bg" data-setbg="{{ Helper::files('slider/'.$item_slider->marketing_slider_image) }}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 text-white">
                        <h2>{{ $item_slider->marketing_slider_name }}</h2>
                        <p>{{ $item_slider->marketing_slider_description }} </p>
                        <a href="{{ route('single_slider', ['slider' => $item_slider->marketing_slider_slug]) }}"
                            class="site-btn sb-dark">Detail</a>
                        <a target="_blank" href="{{ $item_slider->marketing_slider_link }}" class="site-btn sb-white">{{ $item_slider->marketing_slider_button }}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="container">
        <div class="slide-num-holder" id="snh-1"></div>
    </div>
</section>
<!-- Hero section end -->