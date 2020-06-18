@component('component.livewire')
@endcomponent
<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left" style="width:50px;">ID</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-right col-md-1">Price</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-1">Total</th>
            <th id="action" class="text-center col-md-1">Action</th>
        </tr>
    </thead>
    <tbody>
        @livewire('wo-detail')
        @if($model->$key && !old('temp_id'))
        @foreach ($detail as $item)
        <tr>
            <td data-title="ID Product">
                {{ $item->product->item_product_id }}
                <input type="hidden" value="{{ $item->product->item_product_id }}" name="temp[{{$loop->index}}][id]">
            </td>
            <td data-title="Product">
                {{ $item->product->item_product_name }}
                <input type="hidden" value="{{ $item->product->item_product_name }}"
                    name="temp[{{$loop->index}}][name]">
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" name="temp_price[]"
                    class="form-control text-right money temp[{{$loop->index}}][price]"
                    value="{{ $item->production_work_order_detail_price_order }}">
            </td>
            <td data-title="Min" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" class="form-control text-right number temp[{{$loop->index}}][qty]"
                    value="{{ $item->production_work_order_detail_qty_order }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="temp[{{$loop->index}}][total]"
                    class="form-control text-right number temp_total"
                    value="{{ $item->production_work_order_detail_total_order }}">
            </td>
            <td data-title="Action">
                @if ($action_function == 'show')
                <a id="progress" value="{{ $item->product->item_product_id }}"
                    href="{{ route(config('module').'_survey', ['code' => $item->production_work_order_detail_production_work_order_id, 'detail' => $item->product->item_product_id ]) }}"
                    class="btn btn-success btn-block">Survey</a>
                @else
                <a id="delete" value="{{ $item->product->item_product_id }}"
                    href="{{ route(config('module').'_delete', ['code' => $item->production_work_order_detail_production_work_order_id, 'detail' => $item->product->item_product_id ]) }}"
                    class="btn btn-danger btn-block delete-{{ $item->product->item_product_id }}">Delete</a>
                @endif
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
                @if ($model->$key && $detail->contains('item_product_id', $product))
                <a id="delete" value="{{ $product }}"
                    href="{{ route(config('module').'_delete', ['code' => $model->production_vendor_id, 'detail' => $product ]) }}"
                    class="btn btn-danger btn-block delete-{{ $product }}">Delete</a>
                @else
                <button id="delete" value="{{ $product }}" type="button"
                    class="btn btn-danger btn-block">Delete</button>
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>