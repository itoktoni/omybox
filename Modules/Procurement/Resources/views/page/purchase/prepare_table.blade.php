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
                    <th class="text-left col-md-1">ID</th>
                    <th class="text-left col-md-2">Product Name</th>
                    <th class="text-right col-md-1">Price Order</th>
                    <th class="text-right col-md-1">Qty Order</th>
                    <th class="text-right col-md-1">Total Order</th>
                    <th class="text-right col-md-1">Price Sell</th>
                    <th class="text-right col-md-1">Qty Sell</th>
                    <th class="text-right col-md-1">Total Sell</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($model->detail) && !old('temp_id'))
                @foreach ($model->detail as $item)
                <tr id="{{ $item->purchase_detail_option }}">
                    <td data-title="ID Product">
                        {{ $item->purchase_detail_option }}
                        <input type="hidden" value="{{ $item->purchase_detail_option }}" name="temp_id[]">
                        <input type="hidden" value="{{ $item->purchase_detail_option }}" name="temp_option[]">
                        <input type="hidden" value="{{ $item->purchase_detail_item_product_id }}" name="temp_product[]">
                    </td>
                    <td data-title="Product">
                        @php
                        $product = $item->product->item_product_name;
                        $size = ' '.$item->purchase_detail_size.' ' ?? '';
                        $color = $item->color->item_color_name ?? '';
                        $name = $product.' '.$size.' '.$color;
                        @endphp
                        {{ $name ?? '' }}
                        <input type="hidden" value="{{ $name }}" name="temp_name[]">
                    </td>
                    <td data-title="Price Order" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_price[]" class="form-control text-right number"
                            value="{{ $item->purchase_detail_price_order }}">
                    </td>
                    <td data-title="Qty Order" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_qty[]" class="form-control text-right number"
                            value="{{ $item->purchase_detail_qty_order }}">
                    </td>
                    <td data-title="Total Order" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_total[]" class="form-control text-right number"
                            value="{{ $item->purchase_detail_total_order }}">
                    </td>
                    <td data-title="Price Sell" class="text-right col-lg-1">
                        <input type="text" name="temp_price_prepare[]" {{ $model->purchase_status > 2 ? 'readonly' : '' }} class="form-control text-right number temp_price"
                            value="{{ $item->purchase_detail_price_prepare ?? $item->purchase_detail_price_order }}">
                    </td>
                    <td data-title="Qty Sell" class="text-right col-lg-1">
                        <input type="text" name="temp_qty_prepare[]" {{ $model->purchase_status > 2 ? 'readonly' : '' }} class="form-control text-right number temp_qty"
                            value="{{ $item->purchase_detail_qty_prepare ?? $item->purchase_detail_qty_order }}">
                    </td>
                    <td data-title="Total Sell" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_total_prepare[]"
                            class="form-control text-right number temp_total"
                            value="{{ $item->purchase_detail_total_prepare ?? $item->purchase_detail_total_order }}">
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
                        <input type="hidden" value="{{ old('temp_id')[$loop->index] }}" name="temp_id[]">
                        <input type="hidden" value="{{ old('temp_option')[$loop->index] }}" name="temp_option[]">
                        <input type="hidden" value="{{ old('temp_product')[$loop->index] }}" name="temp_product[]">
                    </td>
                    <td data-title="Price" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_price[]" class="form-control text-right number"
                            value="{{ old('temp_price')[$loop->index] }}">
                    </td>
                    <td data-title="Qty" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_qty[]" class="form-control text-right number"
                            value="{{ old('temp_qty')[$loop->index] }}">
                    </td>
                    <td data-title="Total" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_total[]" class="form-control text-right number"
                            value="{{ old('temp_total')[$loop->index] }}">
                    </td>
                    <td data-title="Qty" class="text-right col-lg-1">
                        <input type="text" name="temp_price_prepare[]" class="form-control text-right number temp_price"
                            value="{{ old('temp_price_prepare')[$loop->index] }}">
                    </td>
                    <td data-title="Qty" class="text-right col-lg-1">
                        <input type="text" name="temp_qty_prepare[]" class="form-control text-right number temp_qty"
                            value="{{ old('temp_qty_prepare')[$loop->index] }}">
                    </td>
                    <td data-title="Total" class="text-right col-lg-1">
                        <input type="text" readonly name="temp_total_prepare[]"
                            class="form-control text-right number temp_total"
                            value="{{ old('temp_total_prepare')[$loop->index] }}">
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>