<!DOCTYPE html>
<html>

<style>
h5{
    margin-top: 50px;
}  
</style>
<body>
    <div id='page'>

        <h1 style="text-align:center;">
            <img style="height: 120px;margin:0px auto;" src="{{ Helper::files('logo/'.config('website.logo')) }}"
                alt="{{ config('website.name') }}">
        </h1>
        
        <div style="margin-bottom: 0px;clear: both;width:600px;margin:0px auto;">
            <h2
                style='margin-bottom:20px;padding-top:20px;text-align: center; color:black;line-height: 0; font-weight: bold;'>
                {{ $user }}
            </h2>

            <div
                style="color:white;text-align:center;padding:20px;background-color:#{{ config('website.colors') }};border-radius:20px;">
                <h3 style="text-align:center;">Nikmati {{ $data->marketing_promo_name }} </h3>
                <p style="text-align: center;">
                   {{ $data->marketing_promo_description }}
                </p>
                <h2>CODE : {{ $data->marketing_promo_code }}</h2>
                <p>
                    jika anda ragu dengan penawaran kami, contact kami di
                </p>
                <a style="background-color:#{{ config('website.color') }};color:white;text-decoration: none;padding:12px 10px;border-radius:20px;margin-top:0px;position:absolute;right:50%;margin-right:-80px;"
                    href="{{ route('single_promo', ['slug' => $data->marketing_promo_slug]) }}">Contact {{ config('website.name') }}</a>
            </div>

        </div>

        <h5 style="text-align:center !important;">{!! config('website.address') !!}</h5>
    </div>
</body>

</html>