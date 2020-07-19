<!DOCTYPE html>
<html lang="en">

<head>
    @include(Helper::setExtendFrontend('meta'))
    @stack('css')
</head>

<body>

    @include(Helper::setExtendFrontend('header'))

    @yield('content')

    @include(Helper::setExtendFrontend('footer'))

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00" /></svg></div>

    @include(Helper::setExtendFrontend('js'))

</body>
@stack('js')
<script>

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