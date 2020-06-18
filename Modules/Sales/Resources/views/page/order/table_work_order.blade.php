<div class="panel-body">
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title text-right">Process Split</h2>
        </header>
        <div class="panel-body line {{ $errors->has('hidden_product_id') ? 'has-error' : ''}}">
            <div class="col-md-12 col-lg-12">
                <div class="col-md-12">
                    <div style="margin-left:-30px;" class="form-group">
                        <table id="transaction" class="table table-no-more table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left" style="width:50px;">Index</th>
                                    <th class="text-left col-md-3">Vendor Name</th>
                                    <th class="text-left col-md-3">Product Name</th>
                                    <th class="text-right col-md-1">Sum</th>
                                    <th class="text-right col-md-2">Price</th>
                                    <th class="text-right col-md-1">Qty</th>
                                    <th class="text-right col-md-2">Total</th>
                                    <th class="text-right col-md-2">Default</th>
                                    <th class="text-right col-md-2">Process</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php old('temp_id') ? $looling = old('temp_id') : $looling = $detail; @endphp
                                @foreach ($looling as $item)
                                <tr>
                                    <td class="text-center" data-title="Index">
                                        {{ $loop->index }}
                                        <input type="hidden"
                                            value="{{ old('temp_id')[$loop->index] ?? $item->item_product_id }}"
                                            name="temp_id[]">
                                    </td>
                                    <td class="{{ $errors->has('temp_vendor_id.'.$loop->index) ? 'has-error' : ''}}"
                                        data-title="Vendor Name">
                                        <select name="temp_vendor_id[]" class="form-control">
                                            <option value="">- Vendor -</option>
                                            @for ($i=0;$i < $production->count(); $i++)
                                                <option
                                                    {{ (!old('temp_vendor_id') && $item->production_vendor_id == $production->toArray()[$i]['production_vendor_id']) ? 'selected' : '' }}
                                                    {{ old('temp_vendor_id')[$loop->index] == $production->toArray()[$i]['production_vendor_id'] ? 'selected' : '' }}
                                                    value="{{ $production->toArray()[$i]['production_vendor_id'] }}">
                                                    {{ $production->toArray()[$i]['production_vendor_name'] }}</option>
                                                @endfor
                                        </select>
                                        <input type="hidden"
                                            value="{{ old('temp_vendor_name')[$loop->index] ?? $item->production_vendor_name }}"
                                            name="temp_vendor_name[]">
                                    </td>
                                    <td data-title="Product">
                                        {{ old('temp_name')[$loop->index] ?? $item->item_product_name }}
                                        
                                        <input type="hidden"
                                            value="{{ old('temp_name')[$loop->index] ?? $item->item_product_name }}"
                                            name="temp_name[]">
                                    </td>
                                    <td data-title="Sum" class=" text-right col-lg-1">
                                        {{ old('temp_prepare')[$loop->index] ?? $sales_order->where('production_work_order_detail_item_product_id', $item->item_product_id)->first()->total ?? 0 }}
                                        <input type="hidden" value="{{ old('temp_prepare')[$loop->index] ?? $sales_order->where('production_work_order_detail_item_product_id', $item->item_product_id)->first()->total ?? 0 }}"
                                            name="temp_prepare[]">
                                    </td>
                                    <td data-title="Price" class="text-right col-lg-1">
                                        <input readonly type="text" name="temp_default[]"
                                            class="form-control text-right money"
                                            value="{{ old('temp_default')[$loop->index] ?? $item->sales_order_detail_price_order }}">
                                    </td>
                                    <td data-title="Qty" class="text-right col-lg-1">
                                        <input readonly type="text" name="temp_process[]"
                                            class="form-control text-right number"
                                            value="{{ old('temp_process')[$loop->index] ?? $item->sales_order_detail_qty_order }}">
                                    </td>
                                    <td data-title="Total" class="text-right col-lg-1">
                                        <input readonly type="text" name="temp_total[]"
                                            class="form-control text-right number"
                                            value="{{old('temp_total')[$loop->index] ?? $item->sales_order_detail_total_order }}">
                                    </td>
                                    <td data-title="Default" class=" text-right col-lg-1">
                                        <input type="text" name="temp_price[]" class="form-control text-right number"
                                            value="{{ old('temp_price')[$loop->index] ?? $item->sales_order_detail_price_order }}">
                                    </td>
                                    <td data-title="Process" class="text-right col-lg-1">
                                        <input type="text" name="temp_qty[]" class="form-control text-right number"
                                            value="{{ old('temp_qty')[$loop->index] ?? $item->sales_order_detail_qty_order }}">
                                    </td>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>