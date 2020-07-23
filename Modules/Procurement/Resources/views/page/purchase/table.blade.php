@push('style')
<style>
    .show-table table {
        width: 100%;
    }

    .show-table td[data-title="Action"],
    .show-table #action {
        display: none !important;
    }
</style>
@endpush

<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-1">ID</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-right col-md-1">Price</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-1">Total</th>
            <th id="action" class="text-center col-md-1">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($model->detail) && !old('temp_id'))
        @foreach ($model->detail as $item)
        <tr id="{{ $item->purchase_detail_item_product_id }}">
            <td data-title="ID Product">
                {{ $item->purchase_detail_item_product_id }}
                <input type="hidden" value="{{ $item->purchase_detail_item_product_id }}" name="temp_id[]">
            </td>
            <td data-title="Product">
                {{ $item->product->procurement_product_name ?? '' }} {{ $item->product->display->procurement_unit_name ?? '' }}
                <input type="hidden" value="{{ $item->product->procurement_product_name ?? '' }}" name="temp_name[]">
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" name="temp_price[]" class="form-control text-right number temp_price"
                    value="{{ $item->purchase_detail_price_order }}">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" class="form-control text-right number temp_qty"
                    value="{{ $item->purchase_detail_qty_order }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="temp_total[]" class="form-control text-right number temp_total"
                    value="{{ $item->purchase_detail_total_order }}">
            </td>
            <td data-title="Action">
                <input type="hidden" value="{{ $item->purchase_detail_item_product_id }}" name="temp_product[]">

                <a id="delete" value="{{ $item->purchase_detail_option }}"
                    href="{{ route(config('module').'_delete', ['code' => $item->purchase_detail_purchase_id, 'detail' => $item->item_product_id ]) }}"
                    class="btn btn-danger btn-block">Delete</a>
            </td>
        </tr>
        @endforeach
        @endif
        @if(old('temp_id'))
        @foreach (old('temp_id') as $product)
        <tr>
            <td data-title="ID Product">{{ old('temp_id')[$loop->index] }}</td>
            <td data-title="Product">
                {{ old('temp_name')[$loop->index] }}
                <input type="hidden" name="temp_name[]" value="{{ old('temp_name')[$loop->index] }}" </td> <td
                    data-title="Price" class="text-right col-lg-1">
                <input type="text" name="temp_price[]" class="form-control text-right number temp_price"
                    value="{{ old('temp_price')[$loop->index] }}">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" class="form-control text-right number temp_qty"
                    value="{{ old('temp_qty')[$loop->index] }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="temp_total[]" class="form-control text-right number temp_total"
                    value="{{ old('temp_total')[$loop->index] }}">
            </td>
            <td data-title="Action">
                <input type="hidden" value="{{ old('temp_id')[$loop->index] }}" name="temp_id[]">
                <input type="hidden" value="{{ old('temp_product')[$loop->index] }}" name="temp_product[]">
                @if ($model->$key && $detail->contains('item_product_id', $product))
                <a id="delete"
                    href="{{ route(config('module').'_delete', ['code' => $model->procurement_vendor_id, 'detail' => $product ]) }}"
                    class="btn btn-danger btn-xs btn-block">Delete</a>
                @else
                <button id="delete" value="{{ $product }}" type="button"
                    class="btn btn-danger btn-xs btn-block">Delete</button>
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>