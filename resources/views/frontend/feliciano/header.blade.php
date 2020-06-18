<nav class="header-fixed navbar navbar-expand-lg bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <div class="d-lg-none">
            <a class="header-cart {{ request()->segment(1) == 'cart' ? 'cart-block' : '' }}" href="{{ route('cart') }}">
                <span class="oi oi-cart button-cart"></span>
                <span class="number-cart">
                    {{ Cart::getContent()->count() }}
                </span>
            </a>
        </div>

        <a class="navbar-brand" href="{{ config('app.url') }}">
        <img class="logo" src="{{ Helper::files('logo/min_'.config('website.logo')) }}" alt="{{ config('website.name') }}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ empty(request()->segment(1)) ? 'active' : '' }}"><a
                        href="{{ config('app.url') }}" class="nav-link">Home</a></li>
                <li class="nav-item {{ request()->segment(1) == 'shop' ? 'active' : '' }}"><a href="{{ route('shop') }}"
                        class="nav-link">Menu</a></li>
                <li class="nav-item {{ request()->segment(1) == 'about' ? 'active' : '' }}"><a
                        href="{{ route('about') }}" class="nav-link">About</a></li>
                {{-- @foreach ($public_page as $page)
                <li class="nav-item"><a href="{{ $page->marketing_page_slug }}"
                class="nav-link">{{ $page->marketing_page_name }}</a></li>
                @endforeach --}}
                <li class="nav-item {{ request()->segment(1) == 'contact' ? 'active' : '' }}"><a
                        href="{{ route('contact') }}" class="nav-link">Contact</a></li>
            </ul>
        </div>

        <div class="d-none d-lg-block">
            <a class="header-cart {{ request()->segment(1) == 'cart' ? 'cart-block' : '' }}" href="{{ route('cart') }}">
                <span class="oi oi-cart button-cart"></span>
                <span class="number-cart">
                    {{ Cart::getContent()->count() }}
                </span>
            </a>
        </div>

    </div>
</nav>