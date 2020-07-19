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
                    <th class="text-right col-md-1">Vendor</th>
                    <th class="text-right col-md-1">Receive</th>
                    <th class="text-right col-md-2">Location</th>
                    <th class="text-right col-md-1">Barcode</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($model->detail) || old('temp_id'))
                @foreach (old('temp_id') ?? $model->detail as $item)
                <tr>
                    <td data-title="ID Product">
                        {{ $item->purchase_detail_option ?? old('temp_id')[$loop->index] }}
                        <input type="hidden" value="{{ old('temp_id')[$loop->index] ?? $item->purchase_detail_option }}"
                            name="temp_id[]">
                        <input type="hidden"
                            value="{{old('temp_product')[$loop->index] ?? $item->purchase_detail_item_product_id }}"
                            name="temp_product[]">
                        <input type="hidden"
                            value="{{ old('temp_color')[$loop->index] ?? $item->purchase_detail_color_id }}"
                            name="temp_color[]">
                        <input type="hidden" value="{{ old('temp_size')[$loop->index] ?? $item->purchase_detail_size }}"
                            name="temp_size[]">
                    </td>
                    <td data-title="Product">
                        @php
                        $product = $item->product->item_product_name ?? '';
                        $size = $item->purchase_detail_size ?? '';
                        $color = $item->color->item_color_name ?? '';
                        $name = $product.' '.$size.' '.$color;
                        @endphp

                        {{ old('temp_name')[$loop->index] ?? $name }}
                        <input type="hidden" value="{{ old('temp_name')[$loop->index] ?? $name }}" name="temp_name[]">
                    </td>
                    <td data-title="Qty Order" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_qty[]" class="form-control text-right number"
                            value="{{ old('temp_qty')[$loop->index] ?? $item->purchase_detail_qty_order }}">
                    </td>
                    <td data-title="Vendor" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_prepare[]" class="form-control text-right number"
                            value="{{old('temp_prepare')[$loop->index] ?? $item->purchase_detail_qty_prepare }}">
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
                    <td data-title="Barcode" class="text-right col-lg-2">
                        @if (empty(old('temp_id')) && $item->purchase_detail_barcode && !old('temp_id'))
                        <a class="btn btn-danger btn-xs btn-block" target="__blank"
                            href="{{ route('item_stock_print_multibarcode', ['code' => $item->purchase_detail_barcode]) }}">Print Barcode</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>