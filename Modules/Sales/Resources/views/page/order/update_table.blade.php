<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left" style="width:100px;">ID</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-right col-md-2">Price</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-2">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($brands as $brand)
        @if (Auth::user()->group_user != 'operation')
            
        <tr>
            <td data-title="Brand" colspan="2">
                <span class="text-danger">
                    {{ $brand->item_brand_name }} - {{ $brand->item_brand_description }}
                    <input type="hidden" value="{{ $brand->item_brand_id }}"
                        name="brand[{{ $brand->item_brand_id }}][temp_brand_id]">
                </span>
            </td>
            <td data-title="Ongkir">
                <input type="text" name="brand[{{ $brand->item_brand_id }}][temp_brand_ongkir]" required placeholder="Ongkir"
            class="form-control text-right number temp_qty" value="{{ $brand->sales_order_detail_ongkir ?? '' }}">
            </td>
            <td colspan="2" data-title="Waybill" class="text-right col-lg-1">
                <input type="text" name="brand[{{ $brand->item_brand_id }}][temp_brand_waybill]" placeholder="Waybill"
                    class="form-control text-right number temp_qty" value="{{ $brand->sales_order_detail_waybill ?? '' }}">
            </td>
        </tr>
        @endif
        
        @foreach ($detail as $item)
        @if ($item->product->item_product_item_brand_id == $brand->item_brand_id)

        <tr>
            <td data-title="ID">
                {{ $item->product->item_product_id }}
                <input type="hidden" value="{{ $item->sales_order_detail_sales_order_id }}"
                    name="detail[{{ $loop->iteration }}][temp_order_id]">
                <input type="hidden" value="{{ $item->sales_order_detail_item_product_id }}"
                    name="detail[{{ $loop->iteration }}][temp_product_id]">
                <input type="hidden" value="{{ $brand->item_brand_id }}"
                    name="detail[{{ $loop->iteration }}][temp_brand_id]">
            </td>
            <td data-title="Product">
                {{ $item->product->item_product_name }}
            </td>
            <td data-title="Price" class="text-right col-lg-2">
                <input type="text" name="temp_price[]" readonly class="form-control text-right money temp_price"
                    value="{{ $item->sales_order_detail_price_order }}">
            </td>
            <td data-title="Min" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" readonly class="form-control text-right number temp_qty"
                    value="{{ $item->sales_order_detail_qty_order }}">
            </td>
            <td data-title="Total" class="text-right col-lg-2">
                <input type="text" name="temp_total[]" readonly class="form-control text-right number temp_total"
                    value="{{ $item->sales_order_detail_total_order }}">
            </td>
        </tr>
        @endif
        @endforeach
        @endforeach
        <tr>
            <td data-title="Courier" colspan="4">
                Total Order
            </td>
            <td data-title="Courier" colspan="1">
                <input type="text" readonly class="form-control text-right number temp_total"
                    value="{{ number_format($detail->sum('sales_order_detail_total_order')) }}">
            </td>
        </tr>
        <tr>
            <td data-title="Ongkir" colspan="4">
                Total Ongkir
            </td>
            <td data-title="Ongkir" colspan="1">
                <input type="text" name="sales_order_rajaongkir_ongkir" readonly class="form-control text-right number temp_total"
                    value="{{ old('sales_order_rajaongkir_ongkir') ?? $model->sales_order_rajaongkir_ongkir }}">
            </td>
        </tr>
        @if ($model->sales_order_marketing_promo_code)
        <tr>
            <td data-title="Voucher" colspan="4">
                {{ $model->sales_order_marketing_promo_code }} {{ $model->sales_order_marketing_promo_name }}
            </td>
            <td data-title="Value" colspan="1">
                <input type="text" readonly class="form-control text-right number temp_total"
                    value="-{{ $model->sales_order_marketing_promo_value }}">
            </td>
        </tr>
        @endif
        <tr class="well success">
            <td data-title="Total" colspan="4">
                ( Total Order + Ongkir ) - Discount
            </td>
            <td class="text-right" data-title="Value" colspan="1">
                <h5 style="margin-right:13px;">{{ number_format($model->sales_order_total + $brands->sum('sales_order_detail_ongkir')) }}</h5>
            </td>
        </tr>
</table>