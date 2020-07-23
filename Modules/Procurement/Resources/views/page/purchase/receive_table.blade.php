@push('style')
<style>
.show-table table {
    width: 100%;
}

.has-error {
    background-color: #d2322d !important;
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
                    <th class="text-left col-md-1">ID</th>
                    <th class="text-left col-md-2">Product Name</th>
                    <th class="text-right col-md-1">Qty</th>
                    <th class="text-right col-md-1">Receive</th>
                    <th class="text-right col-md-2">Location</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($model->detail) || old('temp_id'))
                @foreach (old('temp_id') ?? $model->detail as $item)
                <tr>
                    <td data-title="ID Product">
                        {{ $item->purchase_detail_item_product_id ?? old('temp_id')[$loop->index] }}
                        <input type="hidden"
                            value="{{ old('temp_id')[$loop->index] ?? $item->purchase_detail_item_product_id }}"
                            name="temp_id[]">
                    </td>
                    <td data-title="Product">
                        @php
                        $product = $item->product->procurement_product_name ?? '';
                        @endphp
                        {{ old('temp_name')[$loop->index] ?? $product }} / {{ old('satuan')[$loop->index] ?? $item->product->display->procurement_unit_name ?? '' }}
                        <input type="hidden" value="{{ old('temp_name')[$loop->index] ?? $product }}"
                            name="temp_name[]">
                    </td>
                    <td data-title="Qty Order" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_qty[]" class="form-control text-right number"
                            value="{{ old('temp_qty')[$loop->index] ?? $item->purchase_detail_qty_order }}">
                    </td>
                    <td data-title="Receive Order" class="text-right col-lg-1">
                        <input type="text" name="temp_receive[]" {{ $model->purchase_status > 3 ? 'readonly' : '' }}
                            class="form-control text-right number"
                            value="{{ old('temp_receive')[$loop->index] ?? $item->purchase_detail_qty_receive }}">
                    </td>
                    <td data-title="Location"
                        class="text-right col-lg-3 {{ $errors->has('purchase_detail_location_id.'.$loop->index) ? 'has-error' : ''}}">
                        {{ Form::select('purchase_detail_location_id[]', $location , old('purchase_detail_location_id')[$loop->index] ?? $item->purchase_detail_location_id, ['class'=> 'form-control']) }}
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>