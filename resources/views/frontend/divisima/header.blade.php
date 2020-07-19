<!-- Header section -->
<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 text-center text-lg-left">
                    <!-- logo -->
                    <a href="{{ Helper::base_url() }}" class="site-logo">
                        <img src="{{ Helper::files('logo/'.config('website.logo')) }}" alt="">
                    </a>
                </div>
                <div class="col-xl-6 col-lg-5">
                    {!! Form::open(['route' => 'shop','class' => 'header-search-form', 'files' =>
                    true]) !!}
                    <input type="text" name="search" placeholder="Search on divisima ....">
                    <button type="submit"><i class="flaticon-search"></i></button>
                    {!! Form::close() !!}
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="user-panel">
                        @auth
                        <div class="up-item">
                            <i class="flaticon-profile"></i>
                            <a href="{{ route('myaccount') }}">My Account</a> or
                            <a href="{{ route('reset') }}">Logout</a>
                        </div>
                        @endauth
                        @guest
                        <div class="up-item">
                            <i class="flaticon-profile"></i>
                            <a href="{{ route('login') }}">Sign In</a> or
                            <a href="{{ route('register') }}">Create Account</a>
                        </div>
                        @endguest
                        <div id="count" class="up-item">
                            <input type="hidden" id="product_name" value="{{ session()->get('product') ?? null }}">
                            <div class="shopping-card">
                                <i class="flaticon-bag"></i>
                                <span id="cart">{{ Cart::getContent()->count() }}</span>
                            </div>
                            <a href="{{ route('cart') }}">Shopping Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <!-- menu -->
            <ul class="main-menu">
                <li>
                    <div id="home" onclick="location.href = '{{ config('app.url') }}';">HOME</div>
                </li>
                <li><a href="{{ route('category') }}">CATEGORY</a>
                    @isset($public_category)
                    <ul class="sub-menu">
                        @foreach ($public_category->where('item_category_homepage', 1) as $category_item)
                        <li><a
                                href="{{ route('filters', ['type' => 'category', 'slug' => $category_item->item_category_slug]) }}">{{ ucfirst($category_item->item_category_name) }}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endisset
                </li>
                <li><a href="{{ route('contact') }}">CONTACT US</a></li>
                {{-- <li><a href="{{ route('promo') }}">PROMO</a> --}}
                <li><a href="{{ route('shop') }}">SHOP<span class="new"> Sale </span></a></li>
            </ul>
        </div>
    </nav>
</header>
<!-- Header section end -->