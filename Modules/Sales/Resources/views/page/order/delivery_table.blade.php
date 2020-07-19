<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-1">ID</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-right col-md-1">Order</th>
            <th class="text-right col-md-1">Prepare</th>
        </tr>
    </thead>
    <tbody>
        @if($model->$key && !old('temp_id'))
        @foreach ($detail as $item)
        <tr>
            <td data-title="ID Product">
                {{ $item->sales_order_detail_option }}
                <input type="hidden" value="{{ $item->sales_order_detail_sales_order_id }}" name="temp_order[]">
                <input type="hidden" value="{{ $item->sales_order_detail_option }}" name="temp_option[]">
            </td>
            <td data-title="Product">
                {{ $item->product->item_product_name }} {{ $item->sales_order_detail_item_size ?? '' }} {{ $item->color->item_color_name ?? '' }}
            </td>
            <td data-title="Order" class="text-right col-lg-1">
                <input type="text" readonly name="temp_order[]" class="form-control text-right money temp_price"
                    value="{{ $item->sales_order_detail_qty_order }}">
            </td>
            <td data-title="Prepare" class="text-right col-lg-1">
                <input type="text" readonly name="temp_prepare[]" class="form-control text-right number temp_qty"
                    value="{{ $item->sales_order_detail_qty_prepare }}">
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>