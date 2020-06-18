<!doctype html>
<html class="scroll">
<head>
@include(Helper::setExtendBackend('meta'))

@include(Helper::setExtendBackend('css'))

@include(Helper::setExtendBackend('js'))  

</head>
<body>

<section class="body">
    @include(Helper::setExtendBackend('header'))
    <div class="inner-wrapper">
    @include(Helper::setExtendBackend('left'))
    <section role="main" class="content-body">
        <header class="page-header">
            <span class="col-lg-11 col-sm-6 col-xl-3 pull-left" style="color:#A6A3A3;margin-top:15px;z-index: 1;">
                <marquee>
                    <span>test</span>
                </marquee>
            </span>
            <div class="right-wrapper pull-right">       
                <a id="link_menu" class="sidebar-right-toggle" data-open="sidebar-right">
                    <i style="margin-right: -30px;" class="fa fa-paper-plane"></i>
                </a>
            </div>
        </header>
       <div id="screen" class="screen">
            @yield('content')
        </div>
        <div style="padding-bottom: 50px;"></div>
    </section>
    </div>

    @include(Helper::setExtendBackend('right'))
</section>
<script src="{{ Helper::backend('javascripts/theme.js') }}" ></script>
<script src="{{ Helper::backend('javascripts/theme.init.js') }}"></script>
@include(Helper::setExtendBackend('alert'))
@stack('style')
@stack('javascript')
</body>
</html>