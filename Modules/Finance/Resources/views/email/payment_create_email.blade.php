<!DOCTYPE html>
<html>

<style>
h5{
    margin-top: 50px;
}  

body{
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
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
                Hai {{ $data->finance_payment_person }}
            </h2>

            <div
                style="color:white;text-align:center;padding:20px;background-color:#{{ config('website.color') }};border-radius:20px;">
                <h3 style="text-align:center;"> Konfirmasi pembayaran {{ $data->finance_payment_sales_order_id }} </h3>
                <p style="text-align: center;">
                   Tanggal : {{ $data->finance_payment_date->format('d M Y') }}
                </p>
                <h2>Total : {{ number_format($data->finance_payment_amount) }}</h2>
                <p>
                    Notes : {{ $data->finance_payment_note }}
                </p>
                
            </div>

        </div>

        <h5 style="text-align:center !important;">{!! config('website.address') !!}</h5>
    </div>
</body>

</html>