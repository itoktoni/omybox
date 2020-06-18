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
            margin-left: -30px;
        }

        table#border {
            border: 0.5px solid grey;
        }
    </style>

    <title>Document</title>
</head>

<body>
    <table width="100%" id="border" border="0" cellpadding="5" cellspacing="0" id="m_-3784408755349078820templateList" width="97%"
        style="border-collapse:collapse;border-spacing:0;font-size:13px;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0 0 25px;padding:0"
        bgcolor="#FFFFFF">
        <tbody>
            <tr>
                <th colspan="6" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0">
                        No. Order : {{ $master->purchase_id }}
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
                <td align="right" valign="top" colspan="4"
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
                <td align="right" valign="top" colspan="4"
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
                <td align="right" valign="top" colspan="4"
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
                <td align="right" valign="top" colspan="4"
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
                <td align="right" valign="top" colspan="4"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_address ?? '' }}</span>
                </td>
            </tr>

            <tr>
                <th colspan="6" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}"></th>
            </tr>
            <tr>
                <td align="left" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">ID Product
                    </strong>
                </td>
                <td align="left" class="m_-3784408755349078820headingList" valign="top" width="35%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Product
                    </strong>
                </td>
                <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Order</strong>
                </td>
                <td align="center" class="m_-3784408755349078820headingList" valign="top" width="20%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Act Qty</strong>
                </td>
                <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Price</strong>
                </td>
                <td align="right" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Total</strong>
                </td>
            </tr>

            <?php
                            $sub = 0;
                            $total = 0;
                            ?>
            @foreach ($detail as $item)
            <?php
                            $sub = $item->purchase_detail_qty_prepare * $item->purchase_detail_price_prepare;
                            $total = $total + $sub;
                            ?>

            <tr>
                <td align="center" valign="middle" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->purchase_detail_option }}
                </td>
                <td align="left" valign="middle" width="50%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->product->item_product_name }} {{ $item->purchase_detail_size ?? '' }}
                    {{ $item->color->item_color_name ?? '' }}
                </td>
                <td align="center" valign="middle" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->purchase_detail_qty_order }}
                </td>
                <td align="center" valign="middle" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->purchase_detail_qty_prepare }}
                </td>
                <td align="center" valign="middle" width="15%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ number_format( $item->purchase_detail_price_prepare ,0,",",".") }}
                </td>
                <td align="right" valign="middle" width="15%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0"></span><span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        {{ number_format($item->purchase_detail_total_prepare,0,",",".") }}
                    </span>
                </td>
            </tr>
            @endforeach

            <tr>
                <th colspan="6" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}"></th>
            </tr>
            <tr>
                <th colspan="2"
                    style="text-align: left;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:13px;margin:0;padding:5px 0">
                        Total
                    </h2>
                </th>
                <th colspan="4"
                    style="text-align: right;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="text-align: right;font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:13px;margin:0;padding:5px 0">
                        {{ number_format($master->purchase_total_prepare,0,",",".") }}
                    </h2>
                </th>
            </tr>

        </tbody>
    </table>

</body>

</html>