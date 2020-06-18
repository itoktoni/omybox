<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left" style="width:100px;">ID</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-left col-md-2">Tax</th>
            <th class="text-left col-md-1">Color</th>
            <th class="text-left col-md-1">Size</th>
            <th class="text-right col-md-2">Price</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-2">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($detail as $item)
        <tr>
            <td data-title="ID">
                {{ $item->product->item_product_id }}
            </td>
            <td data-title="Product">
                {{ $item->product->item_product_name }}
            </td>
            <td data-title="Tax">
                {{ $item->sales_order_detail_tax_name }} @ {{ number_format($item->sales_order_detail_tax_value) }}
            </td>
            <td data-title="Color">
                {{ $item->color->item_color_name }}
            </td>
            <td data-title="Size">
                {{ $item->sales_order_detail_item_size }}
            </td>
            <td data-title="Price" class="text-right col-lg-2">
                <input type="text" name="temp_price[]" readonly class="form-control text-right money temp_price"
                    value="{{ $item->sales_order_detail_price_order }}">
            </td>
            <td data-title="Min" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" readonly class="form-control text-right number temp_qty"
                    value="{{ $item->sales_order_detail_qty_order }}">
            </td>
            <td data-title="Total" class="text-right col-lg-2">
                <input type="text" readonly name="temp_total[]" class="form-control text-right number temp_total"
                    value="{{ $item->sales_order_detail_total_order }}">
            </td>
        </tr>
        @endforeach
        <tr>
            <td data-title="Courier" colspan="7">
                Total Value
            </td>
            <td data-title="Courier" colspan="1">
                <input type="text" readonly class="form-control text-right number temp_total"
                    value="{{ number_format($detail->sum('sales_order_detail_total_order')) }}">
            </td>
        </tr>
        <tr>
            <td data-title="No">
                1
            </td>
            <td data-title="Courier" colspan="6">
                {{ $model->sales_order_rajaongkir_service }}
            </td>
            <td data-title="Courier" colspan="1">
                <input type="text" readonly class="form-control text-right number temp_total"
                    value="{{ $model->sales_order_rajaongkir_ongkir }}">
            </td>
        </tr>
        @if ($model->sales_order_marketing_promo_code)
        <tr>
            <td data-title="No">
                1
            </td>
            <td data-title="Voucher" colspan="6">
                {{ $model->sales_order_marketing_promo_code }} {{ $model->sales_order_marketing_promo_name }}
            </td>
            <td data-title="Value" colspan="1">
                <input type="text" readonly class="form-control text-right number temp_total"
                value="-{{ $model->sales_order_marketing_promo_value }}">
            </td>
        </tr>
        @endif
        <tr class="well success">
            <td data-title="Total" colspan="7">
                ( Total Value + Ongkir ) - Discount
            </td>
            <td class="text-right" data-title="Value" colspan="1">
                <h5 style="margin-right:13px;">{{ number_format($model->sales_order_total) }}</h5>
            </td>
        </tr>
</table>