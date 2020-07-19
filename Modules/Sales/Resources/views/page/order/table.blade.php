<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-2">Product Name</th>
            <th class="text-left col-md-3">Notes</th>
            <th class="text-right col-md-1">Price</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-1">Total</th>
            <th id="action" class="text-center col-md-1">Action</th>
        </tr>
    </thead>
    <tbody>
        @if($model->$key && !old('temp_id'))
        @foreach ($detail as $item)
        <tr>
            <td data-title="Product">
                {{ $item->product->item_product_name }}
                <input type="hidden" value="{{ $item->product->item_product_id }}" name="temp_id[]">
                <input type="hidden" value="{{ $item->product->item_product_name }}" name="temp_name[]">
            </td>
            <td data-title="Notes">
                {{ $item->sales_order_detail_notes }}
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" name="temp_price[]" class="form-control text-right money temp_price"
                    value="{{ $item->sales_order_detail_price_order }}">
            </td>
            <td data-title="Min" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" class="form-control text-right number temp_qty"
                    value="{{ $item->sales_order_detail_qty_order }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="temp_total[]" class="form-control text-right number temp_total"
                    value="{{ $item->sales_order_detail_total_order }}">
            </td>
            <td data-title="Action">
                <a id="delete" value="{{ $item->product->item_product_id }}"
                    href="{{ route(config('module').'_delete', ['code' => $item->sales_order_detail_sales_order_id, 'detail' => $item->product->item_product_id ]) }}"
                    class="btn btn-danger btn-block delete-{{ $item->product->item_product_id }}">Delete</a>
            </td>
        </tr>
        @endforeach
        @endif
        @if(old('temp_id'))
        @foreach (old('temp_id') as $product)
        <tr>
            <td data-title="Product">
                {{ old('temp_name')[$loop->index] }}
                <input type="hidden" value="{{ $product }}" name="temp_id[]">
                <input type="hidden" name="temp_name[]" value="{{ old('temp_name')[$loop->index] }}">
            </td>
             <td data-title="Notes">
             <input type="text" name="temp_notes[]" class="form-control text-left"
                    value="{{ old('temp_notes')[$loop->index] }}">
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" name="temp_price[]" readonly class="form-control text-right number temp_price"
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
    <tfoot>
        <tr>
            <td data-title="Courier" colspan="5">
                Total Order
            </td>
            <td data-title="Courier" colspan="1">
                <input type="text" id="total_product" name="total_product" readonly class="form-control text-right money" value="{{ old('total_product') ?? '' }}">
            </td>
        </tr>
        <tr>
            <td data-title="Promo" colspan="1">
                Voucher
            </td>
            <td data-title="Voucher" colspan="1">
                <select name="voucher" id="voucher" class="form-control">
                <option value="">Plese Select Promo</option>
                    @foreach($promo as $val)
                    <option {{ old('voucher') == $val->marketing_promo_code ? 'selected' : '' }} value="{{ $val->marketing_promo_code }}">
                        {{ $val->marketing_promo_name }}
                    </option>
                    @endforeach
                </select>
            </td>
             <td data-title="Code" colspan="1">
                <input type="text" name="sales_order_marketing_promo_code" readonly
                    class="form-control text-left temp_promo_code" value="{{ old('sales_order_marketing_promo_code') }}">
            </td>
            <td data-title="Voucher" colspan="2">
                <input type="text" name="sales_order_marketing_promo_name"
                    class="form-control text-left temp_promo_name" value="{{ old('sales_order_marketing_promo_name') }}">
            </td>
            <td data-title="Promo" colspan="1">
                <input type="text" name="promo_value" readonly
                    class="form-control text-right number temp_promo_value" value="{{ old('promo_value') }}">
            </td>
        </tr>
        <tr class="well success">
            <td data-title="Total" colspan="5">
                ( Total Order + Ongkir ) - Discount
            </td>
            <td class="text-right" data-title="Value" colspan="1">
                <h5 id="total_payment" style="margin-right:13px;">
                    {{ old('total') ? number_format(old('total')) : '' }}
                </h5>
            </td>
        </tr>
    </tfoot>
</table>