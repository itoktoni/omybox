<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        table#border {
            border: 0.5px solid grey;
        }
    </style>

    <title>{{ $data->item_stock_barcode }}</title>
</head>

@php
    $color_id = $data->color->item_color_id ?? '';
    $color_name = $data->color->item_color_name ?? '';
    $size = $data->item_stock_size ?? '';
    $barcode = [
        'barcode' => $data->item_stock_barcode,
        'id' => $data->item_stock_product.$color_id.$size,
        'product_id' => $data->item_stock_product,
        'product_name' => $data->product->item_product_name.$size.$color_name,
        'size' => $size,
        'color_id' => $color_id,
        'color_name' => $color_name,
        'location_id' => $data->location->inventory_location_id ?? '',
        'location_name' => $data->location->inventory_location_name ?? '',
        'warehouse_id' => $data->location->warehouse->inventory_warehouse_id,
        'warehouse_name' => $data->location->warehouse->inventory_warehouse_name,
        'qty' => $data->item_stock_qty,
    ];
@endphp

<body style="margin:-40px;padding:20px;width:100%;border:0.1px solid grey;">
    <h4 style="text-align: center;margin-top:0px;margin-bottom:-10px;width: 100%;">{{ $data->product->item_product_name }}
        {{ $data->item_stock_size ?? '' }} {{ $data->color->item_color_name ?? '' }}</h4>
    <h5 style="text-align:center">
        <img style="background-color:white;left:3px;height:133px;border:0.1px solid #d4d4d4;padding:10px;"
            src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(json_encode($barcode), 'QRCODE')}}"
            alt="barcode" />
    </h5>
    <h4 style="text-align: center;margin-top:-15px;width: 100%;">
        {{ $data->location->inventory_location_name }}
        <br>
        {{ $data->location->warehouse->inventory_warehouse_name }}
    </h4>
    <hr style="margin-top:-10px;">
    <h3 style="text-align: center;margin-top:0px;width: 100%;font-size:50px;position:absolute;bottom:-30px;">
        <span style="font-size:20px;position:absolute;top:0px;left:0px;">QTY</span> 
        {{ number_format($data->item_stock_qty) }}
        <span style="font-size:20px;position:relative;margin-left:-10px;">Pcs</span>
    </h3>
</body>

</html>