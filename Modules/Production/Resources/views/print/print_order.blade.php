<!DOCTYPE html>
<html>

@php
$template_master = $master->getTable();
$template_detail = $template_master.'_detail';
$date = $master->{$template_master.'_date'};
$total = 0;
@endphp

<head>
    <link href="{{ Helper::disableSecure('stylesheets/print.min.css') }}" media="all" rel="stylesheet" />
</head>

<body>
    <div id='page'>
        <div>
            <div style="margin-bottom: -20px;clear: both;">
                <h4 style='text-align: center; color:blackhite;line-height: 0;font-size: 1.5em; font-weight: bold;'>
                   WORK ORDER ( {{ $master->production_work_order_id }} )
                </h4>
                <div>
                    <div style="margin-top: 20px;">
                        <table border='0.4' cellpadding='5' cellspacing='0' id='templateList' width='100%'>
                            <tr>
                                <td align='left' colspan='3' valign='top'>
                                    Vendor Name
                                </td>
                                <td align='left' colspan='5' valign='top'>
                                    {{ $vendor->production_vendor_name }}
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='3' valign='top'>
                                    Contact Person
                                </td>
                                <td align='left' colspan='5' valign='top'>
                                    {{ $vendor->production_vendor_description }}
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='3' valign='top'>
                                    Reference
                                </td>
                                <td align='left' colspan='5' valign='top'>
                                    {{ $master->sales_order->sales_order_id }}
                                </td>
                            </tr>
                            <tr>
                                <td align='left' colspan='3' valign='top'>
                                    Created Date
                                </td>
                                <td align='left' colspan='5' valign='top'>
                                    {{ date_format(date_create($master->order_sales_date),"d F Y") }}
                                </td>
                            </tr>

           
                            <tr>
                                <td align='left' width="30px;" colspan='1' style='background-color: #e0e0e0 !important'
                                    valign='top'>
                                    No.
                                </td>
                                <td align='left' colspan='4' style='background-color: #e0e0e0 !important' valign='top'>
                                   Product Name
                                </td>
                                <td align='right' width="100px;" colspan='1'
                                    style='background-color: #e0e0e0 !important' valign='top'>
                                    Qty
                                </td>
                                <td align='right' width="150px;" colspan='1'
                                    style='background-color: #e0e0e0 !important' valign='top'>
                                    Price
                                </td>
                                <td align='right' colspan='1' width="150px;"
                                    style='background-color: #e0e0e0 !important' valign='top'>
                                    Sub Total
                                </td>
                            </tr>
                            @foreach($detail as $item)
                            <tr>
                                <td align='center' colspan="1" valign='middle'>
                                    <span>{{ $loop->iteration }}</span>
                                </td>
                                <td align='left' colspan='4' valign='middle'>
                                    <span>{{ $item->product->item_product_name }}</span>
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <span>{{ $item->{$template_detail.'_qty_order'} }}</span>
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <span>{{ number_format($item->{$template_detail.'_price_order'}) }}</span>
                                </td>
                                <td align='right' colspan='1' valign='middle'>
                                    <span>{{ number_format($item->{$template_detail.'_total_order'}) }}</span>   
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td align='left' colspan='7' valign='middle'>
                                    TOTAL
                                </td>
                                <td align='right' colspan='1' valign='middle'>

                                    <span class='currency positive'></span><span class='amount positive'>
                                        {{ number_format($detail->sum($template_detail.'_total_order')) }}
                                    </span>

                                </td>
                            </tr>
                            </tr>
                        </table>
                    </div>
                </div>

                @isset($master->order_note)
                <div align='right' style='padding:2px 10px;margin-top: 10px;background-color: #e0e0e0 !important'>
                    <p>
                        Note : {{ $master->production_work_order_note }}
                    </p>
                </div>
                @endisset

                <div align="right" style='margin-top: 10px;'>
                    <span style="margin-top: 50px;"> Support By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <p style="margin-top: 70px;">
                        <br>
                        ( {{ ucwords($master->production_work_order_created_by) }} )
                    </p>
                </div>

            </div>
</body>

</html>