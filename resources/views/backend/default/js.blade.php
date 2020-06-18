@if(config('website.env') == 'local')
@include(Helper::setExtendBackend('jsdev'))
@else
@include(Helper::setExtendBackend('jspro'))
@endif
@stack('js')
<script src="{{ Helper::backend('vendor/jquery/jquery.checkboxes.js') }}"></script>
<script src="{{ Helper::backend('vendor/jquery/jquery.alertable.min.js') }}"></script>
<script src="{{ Helper::backend('vendor/jquery/arrow-table.min.js') }}"></script>
<script src="{{ Helper::backend('vendor/pnotify/pnotify.custom.js') }}"></script>
<script src="{{ Helper::backend('javascripts/theme.custom.js') }}"></script>
@if(config('website.pjax'))
<script src="{{ Helper::backend('javascripts/pjax.js') }}"></script>
@if(config('website.env') == 'local')
<script src="{{ Helper::backend('vendor/pjax/pjax.min.js') }}"></script>
@else
<script src="https://cdn.jsdelivr.net/npm/pjax@0.2.8/pjax.min.js"></script>
@endif
@endif

<script>
$(document).ready(function() {
    $("select.form-control").chosen();
});
</script>