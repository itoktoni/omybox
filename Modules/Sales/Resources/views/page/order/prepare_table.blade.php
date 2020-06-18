<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-2">Barcode</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-right col-md-1">Warehouse</th>
            <th class="text-right col-md-1">Location</th>
            <th class="text-right col-md-1">Qty</th>
        </tr>
    </thead>
    <tbody>
        @if($detail)
        @foreach ($detail as $item)

        <tr class="primary">
            <td colspan="4" data-title="Product">
                {{ $item->product->item_product_name }} {{ $item->sales_order_detail_item_size }}
                {{ $item->color->item_color_name ?? '' }}
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" readonly class="form-control text-right number"
                    value="{{ number_format($item->sales_order_detail_qty_order) }}">
            </td>
        </tr>

        @foreach ($stock as $barcode)
        
        @if ($item->sales_order_detail_option == $barcode->item_stock_option && $barcode->item_stock_qty > 0)
        <tr>
            <td data-title="ID Product">
                {{ $barcode->item_stock_barcode }}
            </td>
            <td data-title="Product">
                {{ $barcode->product->item_product_name }} {{ $barcode->item_stock_size }}
                {{ $barcode->color->item_color_name }}
            </td>
            <td data-title="Warehouse" class="text-right col-lg-1">
                {{ $barcode->location->warehouse->inventory_warehouse_name ?? '' }}
            </td>
            <td data-title="Location" class="text-right col-lg-1">
                {{ $barcode->location->inventory_location_name ?? '' }}
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                @php
                $lock = $delivery->where('so_delivery_barcode', $barcode->item_stock_barcode)->first();
                @endphp
                @if ($lock)
                <input type="text" readonly name="temp_stock[]" class="form-control text-right number"
                    value="{{ $lock->so_delivery_qty }}">
                @else
                <input type="text" placeholder="{{ $barcode->item_stock_qty }}" name="temp_stock[]"
                    class="form-control text-right number" value="">
                @endif
                <input type="hidden" value="{{ $item->sales_order_detail_sales_order_id }}" name="temp_order[]">
                <input type="hidden" value="{{ $barcode->item_stock_qty }}" name="temp_ori[]">
                <input type="hidden" value="{{ $item->sales_order_detail_qty_order }}" name="temp_qty[]">
                <input type="hidden" value="{{ $barcode->item_stock_barcode }}" name="temp_barcode[]">
                <input type="hidden" value="{{ $barcode->item_stock_option }}" name="temp_option[]">
            </td>
        </tr>
        @endif

        @endforeach
        @endforeach
        @endif
    </tbody>
</table>