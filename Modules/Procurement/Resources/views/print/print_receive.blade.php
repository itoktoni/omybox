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
        }

        table#border {
            border: 0.5px solid grey;
        }
    </style>

    <title>{{ $master->purchase_id }}</title>
</head>

<body>
    @php
    $data = [
    'id' => $master->purchase_id,
    'customer' => $master->vendor->procurement_vendor_name ?? '',
    ];
    @endphp

    <img style="background-color:white;position:absolute;top:45px;left:3px;height:130px;border:0.1px solid #d4d4d4;padding:10px;"
        src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(json_encode($data), 'QRCODE')}}" alt="barcode" />
    <table width="100%" id="border" border="0" cellpadding="5" cellspacing="0" id="m_-3784408755349078820templateList"
        style="border-collapse:collapse;border-spacing:0;font-size:13px;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0 0 25px;padding:0"
        bgcolor="#FFFFFF">
        <tbody>
            <tr>
                <th colspan="1" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0;text-align:left">
                        RECEIVE PO
                    </h2>
                </th>
                <th colspan="4" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0;text-align:right">
                        No. PO : {{ $master->purchase_id }}
                    </h2>
                </th>
            </tr>
            <tr>
                <td align="right" colspan="1" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Waktu
                        Order
                    </span>
                </td>
                <td align="left" valign="top" colspan="4"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        {{ $master->purchase_created_at->format('d M Y H:i:s') }}
                    </span>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="1" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        Nama Vendor</span>
                </td>
                <td align="left" valign="top" colspan="4"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">

                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        {{ $master->vendor->procurement_vendor_name ?? '' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="1" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Email</span>
                </td>
                <td align="left" valign="top" colspan="4"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <a
                        style="text-align: right;color:#{{ config('website.color') }}!important;font-family:Arial,sans-serif;line-height:1.5;text-decoration:none;font-size:13px;margin:0;padding:0">
                        {{ $master->vendor->procurement_vendor_email }}
                    </a>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="1" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Phone</span>
                </td>
                <td align="left" valign="top" colspan="4"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        {{ $master->vendor->procurement_vendor_phone }}
                    </span>
                </td>
            </tr>

            <tr>
                <td align="right" colspan="1" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Description</span>
                </td>
                <td align="left" valign="top" colspan="4"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        {{ $master->vendor->procurement_vendor_description ?? '' }}
                    </span>
                </td>
            </tr>

            <tr>
                <th colspan="5" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}"></th>
            </tr>
            <tr>
                <td align="left" class="m_-3784408755349078820headingList" valign="top" width="50%"
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
                    <strong style="color:#555;font-size:13px">Sent</strong>
                </td>
                <td align="center" class="m_-3784408755349078820headingList" valign="top" width="10%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                    bgcolor="#F0F0F0">
                    <strong style="color:#555;font-size:13px">Receive</strong>
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
                                $sub = $item->purchase_detail_qty_order * $item->purchase_detail_price_order;
                                $total = $total + $sub;
                                ?>

            <tr>
                <td align="left" valign="middle" width="50%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">
                    {{ $item->product->item_product_name }}
                    {{ $item->purchase_detail_size ?? '' }}
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
                    {{ $item->purchase_detail_qty_receive ?? 0}}
                </td>
                <td align="right" valign="middle" width="30%"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#FFFFFF">

                    @php
                    $size = $item->purchase_detail_size ?? null;
                    $color = $item->color->item_color_name ?? null;
                    $color_id = $item->color->item_color_id ?? null;
                    $data_detail = json_encode([
                    'product' => $item->purchase_detail_option,
                    'size' => $size,
                    'color' => $color_id,
                    'name' => $item->product->item_product_name.$size.$color,
                    'barcode' => '',
                    'qty' => $item->purchase_detail_qty_prepare
                    ]);
                    @endphp

                    <img style="height: 50px;width: 50px;"
                        src="data:image/png;base64,{{ BARCODE2D::getBarcodePNG($data_detail, 'QRCODE') }}"
                        alt="barcode" />

                </td>
            </tr>
            @endforeach

            <tr>
                <th colspan="5" style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}"></th>
            </tr>
            @if ($master->purchase_marketing_promo_value)
            <tr>
                <td align="left" colspan="2" valign="top"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#f0f0f0">
                    <span
                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                        {{ $master->purchase_rajaongkir_service ?? '' }}
                    </span>
                </td>
                <td align="right" valign="top" colspan="2"
                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                    bgcolor="#f0f0f0">
                    <span
                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->purchase_rajaongkir_expedition ?? '' }}</span>
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
                <th colspan="4"
                    style="text-align: right;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                    bgcolor="#{{ config('website.color') }}">
                    <h2
                        style="text-align: right;font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:13px;margin:0;padding:5px 0">
                        {{ number_format($master->purchase_total,0,",",".") }}
                    </h2>
                </th>
            </tr>

        </tbody>
    </table>
</body>

</html>