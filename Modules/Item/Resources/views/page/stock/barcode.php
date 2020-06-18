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
            margin-left: -35px;
        }

        table#border {
            border: 0.5px solid grey;
        }
    </style>

    <title>{{ $master->sales_order_id }}</title>
</head>

<body>

    <img style="position:absolute;top:46px;left:3px;height:133px;border:0.1px solid #d4d4d4;padding:10px;"
        src="data:image/png;base64,{{BARCODE2D::getBarcodePNG($master->sales_order_id, 'QRCODE')}}" alt="barcode" />
    <table>
        <tbody>
            <tr>
                <td bgcolor="#ffffff" id="m_-3784408755349078820contentContainer"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                    <div>
                        <table id="border" border="0" cellpadding="5" cellspacing="0"
                            id="m_-3784408755349078820templateList" width="100%"
                            style="border-collapse:collapse;border-spacing:0;font-size:13px;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0 0 25px;padding:0"
                            bgcolor="#FFFFFF">
                            <tbody>
                                <tr>
                                    <th colspan="1" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                        bgcolor="#{{ config('website.color') }}">
                                        <h2
                                            style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0;text-align:left">
                                            DELIVERY ORDER
                                        </h2>
                                    </th>
                                    <th colspan="3"
                                        style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                        bgcolor="#{{ config('website.color') }}">
                                        <h2
                                            style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0;text-align:right">
                                            No. Order : {{ $master->sales_order_id }}
                                        </h2>
                                    </th>
                                </tr>
                                <tr>
                                    <td align="right" colspan="1" valign="top"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <span
                                            style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Waktu
                                            Transaksi</span>
                                    </td>
                                    <td align="left" valign="top" colspan="3"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <span
                                            style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->sales_order_created_at->format('d M Y H:i:s') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="1" valign="top"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <span
                                            style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                                            Nama Customer</span>
                                    </td>
                                    <td align="left" valign="top" colspan="3"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">

                                        <span
                                            style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->sales_order_rajaongkir_name ?? '' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="1" valign="top"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <span
                                            style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Email</span>
                                    </td>
                                    <td align="left" valign="top" colspan="3"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <a
                                            style="text-align: right;color:#{{ config('website.color') }}!important;font-family:Arial,sans-serif;line-height:1.5;text-decoration:none;font-size:13px;margin:0;padding:0">{{ $master->sales_order_email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="1" valign="top"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <span
                                            style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Phone</span>
                                    </td>
                                    <td align="left" valign="top" colspan="3"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <span
                                            style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->sales_order_rajaongkir_phone }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right" colspan="1" valign="top"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <span
                                            style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Address</span>
                                    </td>
                                    <td align="left" valign="top" colspan="3"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <span
                                            style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->sales_order_rajaongkir_address ?? '' }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="4"
                                        style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                        bgcolor="#{{ config('website.color') }}"></th>
                                </tr>
                                <tr>
                                    <td align="left" class="m_-3784408755349078820headingList" valign="top" width="65%"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                        bgcolor="#F0F0F0">
                                        <strong style="color:#555;font-size:13px">Nama
                                            Barang</strong>
                                    </td>
                                    <td align="center" class="m_-3784408755349078820headingList" valign="top"
                                        width="10%"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                        bgcolor="#F0F0F0">
                                        <strong style="color:#555;font-size:13px">Order</strong>
                                    </td>
                                    <td align="center" class="m_-3784408755349078820headingList" valign="top"
                                        width="10%"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                        bgcolor="#F0F0F0">
                                        <strong style="color:#555;font-size:13px">Prepare</strong>
                                    </td>
                                    <td align="right" class="m_-3784408755349078820headingList" valign="top" width="15%"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                        bgcolor="#F0F0F0">
                                        <strong style="color:#555;font-size:13px">Barcode</strong>
                                    </td>
                                </tr>

                                <?php
                                                $sub = 0;
                                                $total = 0;
                                                ?>
                                @foreach ($detail as $item)
                                <?php
                                                $sub = $item->sales_order_detail_qty_order * $item->sales_order_detail_price_order;
                                                $total = $total + $sub;
                                                ?>

                                <tr>
                                    <td align="left" valign="middle" width="50%"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        {{ $item->product->item_product_name }}
                                    </td>
                                    <td align="center" valign="middle" width="10%"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        {{ $item->sales_order_detail_qty_order }}
                                    </td>
                                    <td align="center" valign="middle" width="15%"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        nol               
                                    </td>
                                    <td align="right" valign="middle" width="30%"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#FFFFFF">
                                        <img src="data:image/png;base64,{{BARCODE1D::getBarcodePNG($item->sales_order_detail_option, 'C128') }}" alt="barcode" />
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                    <th colspan="4"
                                        style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                        bgcolor="#{{ config('website.color') }}"></th>
                                </tr>
                                @if ($master->sales_order_marketing_promo_value)
                                <tr>
                                    <td align="left" colspan="2" valign="top"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#f0f0f0">
                                        <span
                                            style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                                            {{ $master->sales_order_rajaongkir_service ?? '' }}
                                            </span>
                                    </td>
                                    <td align="right" valign="top" colspan="2"
                                        style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                        bgcolor="#f0f0f0">
                                        <span
                                            style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->sales_order_rajaongkir_expedition ?? '' }}</span>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th colspan="1"
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
                                            {{ number_format($master->sales_order_total,0,",",".") }}
                                        </h2>
                                    </th>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                    <table align="left" id="m_-3784408755349078820securityAnnouncementWrapper" width="100%"
                        style="border-collapse:collapse;border-spacing:0;font-size:13px;margin:0;padding:0"
                        bgcolor="#f0f0f0">
                        <tbody>
                            <tr>
                                <td height="5" width="15"
                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                </td>
                                <td height="5" width="24"
                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                </td>
                                <td height="5" width="10"
                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                </td>
                                <td height="5" width="516"
                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                </td>
                                <td height="5" width="15"
                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>