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
            margin-left: -10px;
        }

        table#border {
            border: 0.5px solid grey;
        }
    </style>

    <title>{{ $master->sales_order_id }}</title>
</head>

<body>

    <img style="background-color:white;position:absolute;top:46px;left:3px;height:130px;border:0.1px solid #d4d4d4;padding:10px;"
        src="data:image/png;base64,{{BARCODE2D::getBarcodePNG($master->sales_order_id, 'QRCODE')}}" alt="barcode" />
    <table width="100%" id="border" border="0" cellpadding="5" cellspacing="0" id="m_-3784408755349078820templateList"
        style="border-collapse:collapse;border-spacing:0;font-size:13px;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0 0 25px;padding:0"
        bgcolor="#FFFFFF">
        <tbody>
            <tr>
                <th colspan="1" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0;text-align:left">
                        WORK ORDER (WO)
                    </h2>
                </th>
                <th colspan="3" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0;text-align:right">
                        No. Order : {{ str_replace('SO','WO',$master->sales_order_id) }}
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
                <th colspan="4" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}"></th>
            </tr>
            <tr>
                <td align="left" class="m_-3784408755349078820headingList" valign="top" width="65%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Nama
                        Barang</strong>
                </td>
                <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Order</strong>
                </td>
                <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%"
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
                    {{ $item->product->item_product_name }} {{ $item->sales_order_detail_item_size }}
                    {{ $item->color->item_color_name }}
                </td>
                <td align="center" valign="middle" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->sales_order_detail_qty_order }}
                </td>
                <td align="center" valign="middle" width="15%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->sales_order_detail_qty_prepare ?? 0 }}
                </td>
                <td align="right" valign="middle" width="30%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">

                    @php
                    $size = $item->sales_order_detail_item_size ?? '';
                    $color = $item->color->item_color_name ?? '';
                    $data_detail = json_encode([
                    'product' => $item->sales_order_detail_option,
                    'name' => $item->product->item_product_name.$size.$color,
                    'barcode' => '',
                    'qty' => $item->sales_order_detail_qty_prepare
                    ]);
                    @endphp

                    <img style="height: 50px;width: 50px;"
                        src="data:image/png;base64,{{ BARCODE2D::getBarcodePNG($data_detail, 'QRCODE') }}"
                        alt="barcode" />

                </td>
            </tr>
            @endforeach

            <tr>
                <th colspan="4" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}"></th>
            </tr>

        </tbody>
    </table>

</body>

</html>