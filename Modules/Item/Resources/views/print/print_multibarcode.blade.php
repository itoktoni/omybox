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

        .page-break {
            page-break-after: always;
        }
    </style>

    <title>Print multiple barcode</title>
</head>

<body style="margin:-40px;padding:20px;width:100%;border:0.1px solid grey;">
    @foreach ($data as $multi)
    @php
    $color_id = $multi->color->item_color_id ?? '';
    $color_name = $multi->color->item_color_name ?? '';
    $size = $multi->item_stock_size ?? '';
    $barcode = [
    'barcode' => $multi->item_stock_barcode,
    'id' => $multi->item_stock_product.$color_id.$size,
    'product_id' => $multi->item_stock_product,
    'product_name' => $multi->product->item_product_name.$size.$color_name,
    'size' => $size,
    'color_id' => $color_id,
    'color_name' => $color_name,
    'location_id' => $multi->location->inventory_location_id ?? '',
    'location_name' => $multi->location->inventory_location_name ?? '',
    'warehouse_id' => $multi->location->warehouse->inventory_warehouse_id,
    'warehouse_name' => $multi->location->warehouse->inventory_warehouse_name,
    'qty' => $multi->item_stock_qty,
    ];
    @endphp

    @if (!$loop->first)
    <div class="page-break"></div>
    @endif
    <div class="container">

        <h4 style="text-align: center;margin-top:0px;margin-bottom:-10px;width: 100%;">
            {{ $multi->product->item_product_name }}
            {{ $multi->item_stock_size ?? '' }} {{ $multi->color->item_color_name ?? '' }}</h4>
        <h5 style="text-align:center">
            <img style="background-color:white;left:3px;height:133px;border:0.1px solid #d4d4d4;padding:10px;"
                src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(json_encode($barcode), 'QRCODE')}}"
                alt="barcode" />
        </h5>
        <h4 style="text-align: center;margin-top:-15px;width: 100%;">
            {{ $multi->location->inventory_location_name }}
            <br>
            {{ $multi->location->warehouse->inventory_warehouse_name }}
        </h4>
        <hr style="margin-top:-10px;">
        <h3 style="text-align: center;margin-top:0px;width: 100%;font-size:50px;position:absolute;bottom:-30px;">
            <span style="font-size:20px;position:absolute;top:0px;left:0px;">QTY</span>
            {{ number_format($multi->item_stock_qty) }}
            <span style="font-size:20px;position:relative;margin-left:-10px;">Pcs</span>
        </h3>
    </div>

    @endforeach

</body>


</html>