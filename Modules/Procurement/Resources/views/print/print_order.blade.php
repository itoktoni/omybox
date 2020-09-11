<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
    body {
        margin-top: -30px;
        margin-left: 0px;
    }

    table#border {
        border: 0.5px solid grey;
    }

    
    </style>

    <title>Document</title>
</head>

<body>

    <h5 id="logo" style="text-align:left;">
        <img style="width: 100px;" src="{{ Helper::print('logo/'.config('website.logo')) }}" alt="">
        <div style="margin-left: 10px;font-family:Arial,sans-serif;text-align: left;">
            <h2 style="position: absolute;top: 10px;left: 120px;background-color: white !important">
                <span style="font-weight: bold">OMYBOX</span>
                <br>
                <span style="font-weight: normal;font-size: 12px;text-align: left !important;line-height: 20px ">{!! config('website.address') !!}</span>
                <span style="font-weight: normal;font-size: 12px;margin-top:5px">Email : {{ config('website.email') }}</span>
            </h2>
        </div>    
    </h5>

    <table id="border" align="center" border="0" cellpadding="5" cellspacing="0" id="m_-3784408755349078820templateList"
        width="100%"
        style="border-collapse:collapse;border-spacing:0;font-size:13px;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0 0 25px;padding:0"
        bgcolor="#FFFFFF">
        <tbody>
            <tr>
                <th colspan="5" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin-top:5px;">
                        {{ config('website.name') }}
                    </h2>
                    <h2
                        style="position:absolute;right:10px;color:#ffffff;line-height:1.5;font-size:15px;top:10px;font-family:Arial,sans-serif;">
                        Purchase Order : {{ $master->purchase_id }}
                    </h2>
                </th>
            </tr>
            <tr>
                <td align="left" colspan="2" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Waktu
                        Transaksi</span>
                </td>
                <td align="right" valign="top" colspan="3"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->purchase_created_at->format('d M Y H:i:s') }}</span>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        Vendor</span>
                </td>
                <td align="right" valign="top" colspan="3"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_name ?? '' }}</span>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Email</span>
                </td>
                <td align="right" valign="top" colspan="3"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <a
                        style="text-align: right;color:#{{ config('website.color') }}!important;font-family:Arial,sans-serif;line-height:1.5;text-decoration:none;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_email }}</a>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Phone</span>
                </td>
                <td align="right" valign="top" colspan="3"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_phone }}</span>
                </td>
            </tr>

            <tr>
                <td align="left" colspan="2" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Address</span>
                </td>
                <td align="right" valign="top" colspan="3"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_address ?? '' }}</span>
                </td>
            </tr>

            <tr>
                <th colspan="5" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}"></th>
            </tr>
            <tr>
                <td align="left" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">ID
                    </strong>
                </td>
                <td align="left" class="m_-3784408755349078820headingList" valign="top" width="65%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Product
                    </strong>
                </td>

                <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Qty</strong>
                </td>
                <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Price</strong>
                </td>
                <td align="right" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px;margin-right:5px;">Total</strong>
                </td>
            </tr>

            <?php
            $sub = 0;
            $total = 0;
            ?>
            @foreach ($detail as $item)
            <?php
            $sub = $item->purchase_detail_qty_order * $item->purchase_detail_price_order;
            $total = $total + $sub;
            ?>

            <tr>
                <td align="left" valign="middle" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->purchase_detail_item_product_id }}
                </td>
                <td align="left" valign="middle" width="50%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->product->procurement_product_name }}
                </td>

                <td align="center" valign="middle" width="15%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->purchase_detail_qty_order }} {{ $item->product->display->procurement_unit_name ?? '' }}
                </td>
                <td align="center" valign="middle" width="15%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ number_format( $item->purchase_detail_price_order ,0,",",".") }}
                </td>
                <td align="right" valign="middle" width="15%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0"></span><span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        {{ number_format($item->purchase_detail_total_order,0,",",".") }}
                    </span>
                </td>
            </tr>
            @endforeach

            <tr>
                <th colspan="2"
                    style="text-align: left;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:13px;margin:0;padding:5px 0">
                        Total
                    </h2>
                </th>
                <th colspan="3"
                    style="text-align: right;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="text-align: right;font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:13px;margin:0;padding:5px 0">
                        {{ number_format($detail->sum('purchase_detail_total_order')) }}
                    </h2>
                </th>
            </tr>

        </tbody>
    </table>

    <div class="sign" style="margin-top:-30px;">
        <h5 style="font-family:Arial,sans-serif;text-align:right">
            Menyetujui,
        </h5>

         <h5 style="font-family:Arial,sans-serif;text-align:right;margin-top:80px">
            {{ config('website.sign') }}
        </h5>
    </div>

</body>

</html>