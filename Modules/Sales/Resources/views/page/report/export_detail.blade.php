<table>
    <thead>
        <tr>
            <td>Sales ID</td>
            <td>Create Date</td>
            <td>Customer</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Status</td>
            <td>Total Order</td>
            <td>Promo Code</td>
            <td>Promo Name</td>
            <td>Discount</td>
            <td>Total Ongkir</td>
            <td>Total Data</td>
            <td>Branch</td>
            <td>Ongkir / Branch</td>
            <td>Waybill</td>
            <td>Category Name</td>
            <td>Product ID</td>
            <td>Product Name</td>
            <td>Product Price</td>
            <td>Product Discount</td>
            <td>Product Flag</td>
            <td>Qty Order</td>
            <td>Price Order</td>
            <td>Total Order</td>
            <td>Prepare Order</td>
            <td>Note</td>
        </tr>
    </thead>
    <tbody>
        @php

        $key = [];

        @endphp
        @foreach($export as $data)
        <tr>

            @php
            $diskon = 0;
            $ongkir = 0;
            if ($data->item_product_discount_value) {
                if($data->item_product_discount_type == 1){
                    $diskon = $data->item_product_sell - ($data->item_product_discount_value * $data->item_product_sell);
                }
                else{
                    $diskon = $data->item_product_sell - $data->item_product_discount_value;
                }
            }

            if(!isset($key[$data->item_brand_id])){
                $key[$data->item_brand_id] = $data->sales_order_detail_ongkir;
                $ongkir = $data->sales_order_detail_ongkir;
            }

            @endphp
            
            <td>{{ $data->sales_order_id }} </td>
            <td>{{ $data->sales_order_date ? $data->sales_order_date->format('Y-m-d') : '' }} </td>
            <td>{{ $data->sales_order_rajaongkir_name }} </td>
            <td>{{ $data->sales_order_email }} </td>
            <td>{{ $data->sales_order_rajaongkir_phone }} </td>
            <td>{{ $data->status[$data->sales_order_status][0] ?? '' }} </td>
            <td>{{ $data->sales_order_total }} </td>
            <td>{{ $data->sales_order_marketing_promo_code }} </td>
            <td>{{ $data->sales_order_marketing_promo_name  }} </td>
            <td>{{ $data->sales_order_marketing_promo_value }} </td>
            <td>{{ $data->sales_order_rajaongkir_ongkir  }} </td>
            <td>{{ ($data->sales_order_total - $data->sales_order_rajaongkir_ongkir) - $data->sales_order_marketing_promo_value  }}
            </td>
            <td>{{ $data->item_brand_name }} </td>
            <td>{{ $ongkir }} </td>
            <td>{{ $data->sales_order_detail_waybill }} </td>
            <td>{{ $data->item_category_name }} </td>
            <td>{{ $data->item_product_id }} </td>
            <td>{{ $data->item_product_name }} </td>
            <td>{{ $data->item_product_sell }} </td>
            <td>{{ $diskon }} </td>
            <td>{{ $data->item_product_flag }} </td>
            <td>{{ $data->sales_order_detail_qty_order }} </td>
            <td>{{ $data->sales_order_detail_price_order }} </td>
            <td>{{ $data->sales_order_detail_total_order }} </td>
            <td>{{ $data->sales_order_detail_qty_prepare }} </td>
            <td>{{ $data->sales_order_detail_note }} </td>
            </tr>
            @endforeach
    </tbody>
</table>