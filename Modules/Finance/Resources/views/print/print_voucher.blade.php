<!DOCTYPE html>
<html>

<head>
    <link href="{{ Helper::disableSecure('stylesheets/print.min.css') }}" media="all" rel="stylesheet" />
</head>

<body>
    <div id='page'>
        <div style="margin-bottom: 0px;clear: both;">
            <h4
                style='margin-bottom:20px;text-align: center; color:black;line-height: 0;font-size: 1.2em; font-weight: bold;'>
                Payment Voucher ( {{ $data->finance_payment_voucher }} )
            </h4>

            <div>
                <div style="margin-top: 20px;">
                    <table border='0.4' cellpadding='5' cellspacing='0' id='templateList' width='100%'>
                        <tr>
                            <td align='left' colspan='4' valign='top'>
                                Reference
                            </td>
                            <td align='left' colspan='4' valign='top'>
                                <strong>{{  $data->finance_payment_sales_order_id ?? $data->finance_payment_reference }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td align='left' colspan='4' valign='top'>
                                Tanggal Buat
                            </td>
                            <td align='left' colspan='4' valign='top'>
                                <strong>
                                    {{ date_format(date_create($data->payment_date),"d F Y") }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td align='left' colspan='4' valign='top'>
                                Reference Person
                            </td>
                            <td align='left' colspan='4' valign='top'>
                                <strong>{{ $data->finance_payment_person }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td align='left' colspan='4' valign='top'>
                                Payment Description
                            </td>
                            <td align='left' colspan='4' valign='top'>
                                <strong>{{ $data->finance_payment_description }}</strong>
                            </td>
                        </tr>

                        <tr>
                            <th colspan='8' style='background: #{{ config('website.color') }} !important'>
                            </th>
                        </tr>
                        <tr>
                            <td align='left' width="30px;" colspan='1' style='background-color: #e0e0e0 !important'
                                valign='top'>
                                <strong>No.</strong>
                            </td>
                            <td align='left' colspan='4' style='background-color: #e0e0e0 !important' valign='top'>
                                <strong>Account From</strong>
                            </td>
                            <td align='right' width="100px;" colspan='1' style='background-color: #e0e0e0 !important'
                                valign='top'>
                                <strong>Account To</strong>
                            </td>
                            <td align='right' width="150px;" colspan='1' style='background-color: #e0e0e0 !important'
                                valign='top'>
                                <strong>Tanggal Submit</strong>
                            </td>
                            <td align='right' colspan='1' width="150px;" style='background-color: #e0e0e0 !important'
                                valign='top'>
                                <strong>Value</strong>
                            </td>
                        </tr>
                        <tr>
                            <td align='left' width="30px;" colspan='1' style='background-color: #00000 !important'
                                valign='top'>
                                <strong>No.</strong>
                            </td>
                            <td align='left' colspan='4' style='background-color: #00000 !important' valign='top'>
                                <strong>
                                    {{ $data->finance_payment_from }}
                                </strong>
                            </td>
                            <td align='right' width="100px;" colspan='1' style='background-color: #00000 !important'
                                valign='top'>
                                <strong>{{ $data->finance_payment_to }}</strong>
                            </td>

                            <td align='right' colspan='1' width="150px;" style='background-color: #00000 !important'
                                valign='top'>
                                <strong>{{ $data->finance_payment_created_at }}</strong>
                            </td>
                            <td align='right' width="150px;" colspan='1' style='background-color: #00000 !important'
                                valign='top'>
                                <strong>{{ number_format($data->finance_payment_amount) }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td align='left' colspan='7' valign='top'>
                                <strong>TOTAL PEMBAYARAN</strong>
                            </td>
                            <td align='right' class='grandTotal' colspan='1' valign='top'>
                                <strong>{{ number_format($data->finance_payment_approve_amount) }}</strong>
                            </td>
                        </tr>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>