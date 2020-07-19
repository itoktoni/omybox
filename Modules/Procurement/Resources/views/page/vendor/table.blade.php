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

<div class="col-md-12">
    <div style="margin-left:-30px;" class="form-group">
        <table id="transaction" class="table table-no-more table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-left" style="width:50px;">ID</th>
                    <th class="text-left col-md-4">Product Name</th>
                    <th class="text-right col-md-1">Price</th>
                    <th class="text-right col-md-1">Min</th>
                    <th class="text-right col-md-1">Max</th>
                    <th id="action" class="text-center col-md-1">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($model->$key && !old('temp_id'))
                @foreach ($detail as $item)
                <tr>
                    <td data-title="ID Product">
                        {{ $item->item_product_id }}
                        <input type="hidden" value="{{ $item->item_product_id }}" name="temp_id[]">
                    </td>
                    <td data-title="Product">
                        {{ $item->item_product_name }}
                        <input type="hidden" value="{{ $item->item_product_name }}" name="temp_name[]">
                    </td>
                    <td data-title="Price" class="text-right col-lg-1">
                        <input type="text" name="temp_price[]" class="form-control text-right number"
                            value="{{ $item->procurement_vendor_product_price }}">
                    </td>
                    <td data-title="Min" class="text-right col-lg-1">
                        <input type="text" name="temp_min[]" class="form-control text-right number"
                            value="{{ $item->procurement_vendor_product_min }}">
                    </td>
                    <td data-title="Max" class="text-right col-lg-1">
                        <input type="text" name="temp_max[]" class="form-control text-right number"
                            value="{{ $item->procurement_vendor_product_max }}">
                    </td>
                    <td data-title="Action">
                        <a id="delete"
                            href="{{ route(config('module').'_delete', ['code' => $item->procurement_vendor_product_vendor_id, 'detail' => $item->item_product_id ]) }}"
                            class="btn btn-danger btn-xs btn-block">Delete</a>
                    </td>
                </tr>
                @endforeach
                @endif
                @if(old('temp_id'))
                @foreach (old('temp_id') as $product)
                <tr>
                    <td data-title="ID Product">
                        {{ $product }}
                        <input type="hidden" value="{{ $product }}" name="temp_id[]">
                    </td>
                    <td data-title="Product">
                        {{ old('temp_name')[$loop->index] }}
                        <input type="hidden" name="temp_name[]" value="{{ old('temp_name')[$loop->index] }}" </td> <td
                            data-title="Price" class="text-right col-lg-1">
                        <input type="text" name="temp_price[]" class="form-control text-right number"
                            value="{{ old('temp_price')[$loop->index] }}">
                    </td>
                    <td data-title="Min" class="text-right col-lg-1">
                        <input type="text" name="temp_min[]" class="form-control text-right number"
                            value="{{ old('temp_min')[$loop->index] }}">
                    </td>
                    <td data-title="Max" class="text-right col-lg-1">
                        <input type="text" name="temp_max[]" class="form-control text-right number"
                            value="{{ old('temp_max')[$loop->index] }}">
                    </td>
                    <td data-title="Action">
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
    </div>
</div>