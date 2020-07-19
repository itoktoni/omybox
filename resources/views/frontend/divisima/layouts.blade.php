<!DOCTYPE html>
<html lang="zxx">

<head>
    @include(Helper::setExtendFrontend('meta'))
    @stack('css')

    <style>

        h1, h2, h3, h4, h5, h6{
            color: #{{ config('website.colors') }} !important;
        }

        .footer-widget h2{
            color:#ffffff !important;
        }

        .main-navbar, .footer-section,
        .cf-title, 
        .site-btn.sb-dark {
            background-color: #{{ config('website.colors') }} !important;
        }

        .shopping-card span, .site-btn, 
        .product-item .tag-sale,
        .map,
        .cart-table .total-cost,
        .main-menu li a .new
        {
            background-color: #{{ config('website.color') }} !important;
            background: #{{ config('website.color') }} !important;
        }
       
        .footer-widget ul li a:hover:after,
        .category-menu li a:hover:after,
        .category-menu ul li a:hover:after,
        .category-menu li:hover:a,
        .footer-widget ul li a:hover:after,
        .footer-widget ul li a:after
        {
            background-color: #{{ config('website.color') }} !important;
            background: #{{ config('website.color') }} !important;
        }

        .footer-widget ul li a:hover:after,
        .footer-widget ul li a:after,
        .category-menu li a:hover:after,
        .category-menu li a:after
        {
            border:1px solid #{{ config('website.color') }} !important;
        }

        .contact-widget .con-info span,
        .main-menu li:hover>a,
        .promo-code-form button,
        .category-menu li a:hover:after,
        .category-menu li:hover>a,
        #home:hover,
        .active
        {
            color: #{{ config('website.color') }} !important;
        }

        .notiny-theme-dark {
            background-color: #{{ config('website.color') }} !important;
            color: #f5f5f5;
        }
    </style>
</head>

<body>

    @include(Helper::setExtendFrontend('header'))
    <div id="pjax">
        @yield('content')
    </div>
    @include(Helper::setExtendFrontend('footer'))
    @include(Helper::setExtendFrontend('js'))

    <div id="alert">
        @if ($errors->any())
        <script type="text/javascript">
            $(function() {
                @foreach ($errors->all() as $error)
                    $.notiny({ text: '{{ $error }}', position: 'right-top' });
                @endforeach
            });
        </script>
        @endif
    </div>

</body>
@stack('js')
<script>
    $(document).ready(function() {
    $("select.form-control.chosen").chosen();
    $(".date").flatpickr({
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
    });
});

    (function () {
        var options = {
            whatsapp: "{{ config('website.phone') }}", // WhatsApp number
            call_to_action: "", // Call to action
            position: "right", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();

</script>

</html>