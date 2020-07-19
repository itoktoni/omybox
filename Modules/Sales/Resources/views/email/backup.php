<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ config('website.name') }}</title>
    @php
    $template_master = $master->getTable();
    $template_detail = $template_master.'_detail';
    $date = $master->{$template_master.'_date'};
    $total = 0;
    @endphp
    @include(Helper::setViewEmail('order_css_order', 'sales'))
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table id="title">
                        <tr>
                            <td id="header" class="title">
                                <img src="{{ Helper::files('logo/'.config('website.logo')) }}" alt="">
                            </td>

                            <td>
                                <span class="date">Created: {{ $date->toFormattedDateString() }}</span>
                                <h4>Sales Order #{{ $master->sales_order_id }}</h4>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="col-md-4">
                                {{ $master->sales_order_rajaongkir_name ?? '' }}<br>
                                {{ $master->sales_order_email ?? '' }}<br>
                                {{ $master->sales_order_rajaongkir_phone ?? '' }}<br>
                            </td>

                            <td class="col-md-8">
                                {{ $master->sales_order_rajaongkir_address ?? '' }}<br>
                                {{ $master->sales_order_rajaongkir_expedition ?? '' }}<br>
                                {{ $master->sales_order_rajaongkir_service ?? '' }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Item
                </td>

                <td>
                    Qty
                </td>

                <td>
                    Price
                </td>

                <td>
                    Total
                </td>
            </tr>
            @foreach ($detail as $item)
            <tr class="item">
                <td>
                    {{ $item->product->item_product_name }}
                </td>

                <td>
                    {{ $item->{$template_detail.'_qty_order'} }}
                </td>

                <td>
                    {{ number_format($item->{$template_detail.'_price_order'}) }}
                </td>

                <td>
                    {{ number_format($item->{$template_detail.'_total_order'}) }}
                </td>
            </tr>
            @endforeach

            <tr class="item">
                <td colspan="3">
                    {{ $master->sales_order_rajaongkir_expedition ?? '' }}
                </td>
            
                <td>
                    {{ number_format($master->sales_order_rajaongkir_ongkir) }}
                </td>
            </tr>
            <tr class="voucher">
                <td colspan="3">
                    Voucher
                </td>
            
                <td>
                    -{{ number_format($detail->sum($template_detail.'_total_order')) }}
                </td>
            </tr>
            <tr class="item last heading">
                <td colspan="3">
                    Total
                </td>

                <td>
                    {{ number_format($detail->sum($template_detail.'_total_order')) }}
                </td>
            </tr>

        </table>
    </div>
</body>

</html>