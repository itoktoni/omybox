<section class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="footer-widget about-widget">
                    <h2>About</h2>
                    <p>{!! config('website.description') !!}</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="footer-widget about-widget">
                    <h2>Page</h2>
                    @if ($public_page->count() > 5)
                    @php
                    $count_page = $public_page->count() / 2;
                    $parsing_page = $public_page->chunk(round($count_page));
                    @endphp
                    @foreach ($parsing_page as $header_footer_page)
                    <ul>
                        @foreach ($header_footer_page as $detail_footer_page)
                        <li>
                            <a href="{{ route('page', ['slug' => $detail_footer_page->marketing_page_slug]) }}">
                                {{ $detail_footer_page->marketing_page_name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endforeach
                    @else
                    <ul>
                        @foreach ($public_page as $public_item_page)
                        <li>
                            <a href="{{ route('page', ['slug' => $public_item_page->marketing_page_slug]) }}">
                                {{ $public_item_page->marketing_page_name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="footer-widget contact-widget">
                    <h2>Information</h2>
                    <div class="con-info">
                        <span>Phone : </span>
                        <p>{{ config('website.phone') }}</p>
                    </div>
                    <div class="con-info">
                        <span>Email : </span>
                        <a href="mailto:{{ config('website.email') }}">
                            <p>{{ config('website.email') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="social-links-warp">
        <div class="container">
            @include(Helper::setExtendFrontend('sosmed'))
            <p class="text-white text-center mt-5">{{ config('website.footer') }}</p>
        </div>
    </div>
</section>