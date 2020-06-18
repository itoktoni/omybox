<table width=100%>
    <tbody>
        <tr>
            <td bgcolor="#ffffff" id="m_-3784408755349078820contentContainer"
                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                <table align="left" width="100%" style="border-collapse:collapse;border-spacing:0;margin:0;padding:0">
                    <tbody>
                        <tr>
                            <td width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td align="left" width="550"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                <table align="center" width="100%"
                                    style="border-collapse:collapse;border-spacing:0;margin:0;padding:0">
                                    <tbody>
                                        <tr>
                                            <td
                                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                                <div style="margin:10px 2px -25px">
                                                    <p
                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:0">
                                                        Notification Purchase Order
                                                    </p>

                                                </div>
                                                <div style="margin:10px 2px">
                                                    <br>
                                                    <table border="0" cellpadding="5" cellspacing="0"
                                                        id="m_-3784408755349078820templateList" width="100%"
                                                        style="border-collapse:collapse;border-spacing:0;font-size:13px;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0 0 25px;padding:0"
                                                        bgcolor="#FFFFFF">
                                                        <tbody>
                                                            <tr>
                                                                <th colspan="4"
                                                                    style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                                                    bgcolor="#{{ config('website.color') }}">
                                                                    <h2
                                                                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:15px;font-weight:bold;margin:0;padding:5px 0">
                                                                        No. Order : {{ $master->purchase_id }}
                                                                    </h2>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Waktu
                                                                        Transaksi</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->purchase_created_at->format('d M Y H:i:s') }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                                                                        Nama Vendor</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">

                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_name ?? '' }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Email</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <a
                                                                        style="text-align: right;color:#{{ config('website.color') }}!important;font-family:Arial,sans-serif;line-height:1.5;text-decoration:none;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_email }}</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Phone</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="text-align: right;font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_phone }}</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td align="left" colspan="1" valign="top"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">Address</span>
                                                                </td>
                                                                <td align="right" valign="top" colspan="3"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">{{ $master->vendor->procurement_vendor_address ?? '' }}</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th colspan="4"
                                                                    style="border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                                                    bgcolor="#{{ config('website.color') }}"></th>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"
                                                                    class="m_-3784408755349078820headingList"
                                                                    valign="top" width="65%"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                                                    bgcolor="#F0F0F0">
                                                                    <strong style="color:#555;font-size:13px">Nama
                                                                        Barang</strong>
                                                                </td>
                                                                <td align="right"
                                                                    class="m_-3784408755349078820headingList"
                                                                    valign="top" width="15%"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;font-size:11px;margin:0;padding:5px 10px"
                                                                    bgcolor="#F0F0F0">
                                                                    <strong
                                                                        style="color:#555;font-size:13px">Total</strong>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                            $sub = 0;
                                                            $total = 0;
                                                            ?>
                                                            @foreach ($detail as $item)
                                                            <?php
                                                            $sub = $item->purchase_detail_qty_order * $item->purchase_detail_price_order;
                                                            $total = $total + $sub;
                                                            ?>

                                                            <tr>
                                                                <td align="left" valign="middle" width="50%"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    {{ $item->product->item_product_name }}
                                                                    {{ $item->purchase_detail_size }}
                                                                    {{ $item->color->item_color_name ?? '' }}
                                                                </td>
                                                                <td align="right" valign="middle" width="25%"
                                                                    style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#555;line-height:1.5;border-bottom-color:#cccccc;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px 10px"
                                                                    bgcolor="#FFFFFF">
                                                                    <span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0"></span><span
                                                                        style="font-family:Arial,sans-serif;color:#555;line-height:1.5;font-size:13px;margin:0;padding:0">
                                                                        {{ number_format($item->purchase_detail_qty_prepare,0,",",".") }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                            <tr>
                                                                <th colspan="1"
                                                                    style="text-align: left;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                                                    bgcolor="#{{ config('website.color') }}">
                                                                    <h2
                                                                        style="font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:13px;margin:0;padding:5px 0">
                                                                        Total
                                                                    </h2>
                                                                </th>
                                                                <th colspan="3"
                                                                    style="text-align: right;border-bottom-style:none;color:#ffffff;padding-left:10px;padding-right:10px"
                                                                    bgcolor="#{{ config('website.color') }}">
                                                                    <h2
                                                                        style="text-align: right;font-family:Arial,sans-serif;color:#ffffff;line-height:1.5;font-size:13px;margin:0;padding:5px 0">
                                                                        {{ number_format($detail->sum('purchase_detail_qty_prepare')) }}
                                                                    </h2>
                                                                </th>
                                                            </tr>

                                                        </tbody>
                                                    </table>


                                            </td>
                                            <td width="15"
                                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="30" width="15"
                                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                            </td>
                                            <td height="30" width="550"
                                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                            </td>
                                            <td height="30" width="15"
                                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                            <td width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                        </tr>
                        <tr>
                            <td height="30" width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td height="30" width="550"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                            <td height="30" width="15"
                                style="border-collapse:collapse;border-spacing:0;font-family:Arial,sans-serif;color:#999;line-height:1.5;margin:0;padding:0">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        
    </tbody>
</table>