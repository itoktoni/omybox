<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-2">Product Name</th>
            <th class="text-left col-md-6">Catatan</th>
            <th class="text-right col-md-2">Price</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-1">Prepare</th>
            <th class="text-right col-md-2">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
        $harga = $total_harga = $total = 0;
        @endphp
        @foreach ($detail as $item)
        @if ($item->product->item_product_item_brand_id == Auth::user()->branch)
        @php
        $harga = $item->sales_order_detail_qty_order * $item->sales_order_detail_price_order;
        $total_harga = $harga + $total_harga;
        @endphp

        <tr>
            <td data-title="Product">
                {{ $item->product->item_product_name }}
                <input type="hidden" value="{{ $item->sales_order_detail_item_product_id }}" name="temp_id[]">
            </td>
            <td data-title="Catatan">
                {{ $item->sales_order_detail_notes }}
            </td>
            <td data-title="Price" class="text-right col-lg-2">
                <input type="text" name="temp_price[]" readonly class="form-control text-right money temp_price"
                    value="{{ $item->sales_order_detail_price_order }}">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" readonly class="form-control text-right number temp_qty"
                    value="{{ $item->sales_order_detail_qty_order }}">
            </td>
            <td data-title="Prepare" class="text-right col-lg-1">
                <input type="text" name="temp_prepare[]" class="form-control text-right number temp_qty"
                    value="{{ $item->sales_order_detail_qty_prepare }}">
            </td>
            <td data-title="Total" class="text-right col-lg-2">
                <input type="text" name="temp_total[]" readonly class="form-control text-right number temp_total"
                    value="{{ $item->sales_order_detail_total_order }}">
            </td>
        </tr>

        @endif
        @endforeach
        <tr>
            <td data-title="Total Order" colspan="5">
                Total Order
            </td>
            <td data-title="Courier" colspan="1">
                <input type="text" readonly class="form-control text-right number temp_total"
                    value="{{ number_format($total_harga) }}">
            </td>
        </tr>
        <tr>
            <td data-title="Ongkir" colspan="5">
                Total Ongkir
            </td>
            <td data-title="Ongkir" colspan="1">
                <input type="text" name="sales_order_rajaongkir_ongkir" readonly
                    class="form-control text-right number temp_total" value="{{ old('sales_order_rajaongkir_ongkir')}}">
            </td>
        </tr>
        @if ($model->sales_order_marketing_promo_code)
        <tr>
            <td data-title="Voucher" colspan="5">
                {{ $model->sales_order_marketing_promo_code }} {{ $model->sales_order_marketing_promo_name }}
            </td>
            <td data-title="Value" colspan="1">
                <input type="text" readonly class="form-control text-right number temp_total"
                    value="-{{ $model->sales_order_marketing_promo_value }}">
            </td>
        </tr>
        @endif
        <tr class="well success">
            <td data-title="Total" colspan="5">
                Grand Total
            </td>
            <td class="text-right" data-title="Value" colspan="1">
                <h5 style="margin-right:13px;">
                    {{ number_format($total_harga - $model->sales_order_marketing_promo_value) }}</h5>
            </td>
        </tr>
</table>