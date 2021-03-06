<nav class="header-fixed navbar navbar-expand-lg bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">


        <a class="navbar-brand" href="{{ config('app.url') }}">
            <img class="logo" src="{{ Helper::files('logo/min_'.config('website.logo')) }}"
                alt="{{ config('website.name') }}">
        </a>
        <div class="d-lg-none">
            <a class="header-cart {{ request()->segment(1) == 'cart' ? 'cart-block' : '' }}" href="{{ route('cart') }}">
                <span class="oi oi-cart button-cart"></span>
                <span class="number-cart">
                    {{ Cart::getContent()->count() }}
                </span>
            </a>
            @auth
            <a class="header-auth {{ request()->segment(1) == 'cart' ? 'cart-block' : '' }}"
                href="{{ route('reset') }}">
                <span class="button-auth oi oi-share-boxed"></span>
            </a>
            @endauth
            @guest
            <a class="header-auth {{ request()->segment(1) == 'cart' ? 'cart-block' : '' }}"
                href="{{ route('login') }}">
                <span class="button-auth oi oi-person"></span>
            </a>
            @endguest

        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ empty(request()->segment(1)) ? 'active' : '' }}">
                    <a href="{{ config('app.url') }}" class="nav-link">Home</a>
                </li>
                @auth
                <li class="nav-item {{ request()->segment(1) == 'myaccount' ? 'active' : '' }}">
                    <a href="{{ route('myaccount') }}" class="nav-link">My Account</a>
                </li>
                @endauth
                <li class="nav-item {{ request()->segment(1) == 'shop' ? 'active' : '' }}">
                    <a href="{{ route('shop') }}" class="nav-link">Menu</a>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'about' ? 'active' : '' }}">
                    <a href="{{ route('about') }}" class="nav-link">About</a>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'galery' ? 'active' : '' }}">
                    <a href="{{ route('galery') }}" class="nav-link">Galery</a>
                </li>
                <li class="nav-item {{ request()->segment(1) == 'contact' ? 'active' : '' }}">
                    <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                </li>
            </ul>
        </div>

        <div class="d-none d-lg-block">
            <a class="header-cart {{ request()->segment(1) == 'cart' ? 'cart-block' : '' }}" href="{{ route('cart') }}">
                <span class="oi oi-cart button-cart"></span>
                <span class="number-cart">
                    {{ Cart::getContent()->count() }}
                </span>
            </a>
            @auth
            <a class="header-auth {{ request()->segment(1) == 'cart' ? 'cart-block' : '' }}"
                href="{{ route('reset') }}">
                <span class="button-auth oi oi-share-boxed"></span>
            </a>
            @endauth
            @guest
            <a class="header-auth {{ request()->segment(1) == 'cart' ? 'cart-block' : '' }}"
                href="{{ route('login') }}">
                <span class="button-auth oi oi-person"></span>
            </a>
            @endguest
        </div>

    </div>
</nav>