@extends(Helper::setExtendFrontend())

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js">
</script>
@endpush

@section('content')
<section class="ftco-section">
    <div class="container">
        <div class="row no-gutters justify-content-center mb-5 pb-2">
            <div class="col-md-12 text-center heading-section ftco-animate">
                <h2 class="master-header mb-4">My Order</h2>
                <h4 class="child-header"><a href="{{ route('userprofile') }}">Update Profile</a></h4>
            </div>
        </div>
        <div class="row no-gutters">

            <div class="card-body">
                <table id="force-responsive" class="table table-table table-bordered">
                    <thead>
                        <tr>
                            <th width="100" scope="col">No. Order</th>
                            <th class="text-right" scope="col">Tanggal</th>
                            <th class="text-right" scope="col">Harga</th>
                            <th class="text-right" scope="col">Discount</th>
                            <th class="text-right" scope="col">Ongkir</th>
                            <th class="text-right" scope="col">Total</th>
                            <th class="text-right" scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order as $item)
                        <tr style="position:relative">
                            <td data-header="No. Order">
                                <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal"
                                    data-target="#{{ $item->sales_order_id ?? '' }}">
                                    {{ $item->sales_order_id ?? '' }}
                                </button>
                            </td>
                            <td data-header="Tanggal" class="text-right">
                                {{ $item->sales_order_date->format('d M Y') }}
                            </td>
                            <td data-header="Harga" class="text-right">
                                {{ number_format($item->sales_order_total) ?? '' }}
                            </td>
                            <td data-header="Discount" class="text-right">
                                -{{ number_format($item->sales_order_marketing_promo_value) ?? '' }}
                            </td>
                            <td data-header="Discount" class="text-right">
                                {{ number_format($item->sales_order_rajaongkir_ongkir) ?? '' }}
                            </td>
                            <td data-header="Total" class="text-right">
                                {{ number_format(($item->sales_order_total + $item->sales_order_rajaongkir_ongkir) - $item->sales_order_marketing_promo_value) ?? '' }}
                            </td>
                            <td data-header="Status" class="text-right">
                                {{ $status[$item->sales_order_status] ?? '' }}
                            </td>
                           
                        </tr>
                        <!-- Modal Order -->
                        <div class="modal fade" id="{{ $item->sales_order_id ?? '' }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">No.
                                            Order :
                                            {{ $item->sales_order_id ?? '' }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <ul class="list-group">
                                            @if ($item->detail->count() > 0)
                                            @foreach ($item->detail as $detail)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">

                                                {{ $detail->product->item_product_name ?? '' }}
                                                <br>
                                                [
                                                {{ $detail->sales_order_detail_qty_order }}
                                                pcs *
                                                {{ number_format($detail->sales_order_detail_price_order) }}
                                                ]
                                                <br>
                                                Total :
                                                {{ number_format($detail->sales_order_detail_price_order * $detail->sales_order_detail_qty_order) }}

                                                <span class="col-md-2">
                                                    <div class="row">
                                                        @isset($detail->product->item_product_image)
                                                        <img class="img-fluid img-thumbnail"
                                                            src="{{ Helper::files('product/'.$detail->product->item_product_image) }}"
                                                            alt="">
                                                        @endisset
                                                    </div>

                                                </span>
                                            </li>
                                            @endforeach
                                            @endif
                                            @if ($item->sales_order_marketing_promo_name)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                Voucher : {{ $item->sales_order_marketing_promo_name }}
                                                <span>-{{ number_format($item->sales_order_marketing_promo_value) ?? '' }}</span>
                                            </li>
                                            @endif
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                Total Ongkir
                                                <span>{{ number_format($item->sales_order_rajaongkir_ongkir) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <div style="position:absolute;bottom:20px;left:20px;">
                                                <div class="container">
                                                    Grand Total
                                                </div>
                                            </div>
                                            <div class="text-right" style="margin-right:35px;">
                                                {{ number_format($item->sales_order_total + $item->sales_order_rajaongkir_ongkir) ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal order -->

                        @empty
                        <tr>
                            <td colspan="7" data-header="Empty Order">
                                Empty Order
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</section>
@endsection

@push('javascript')
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
		$('#force-responsive').DataTable();
	});
</script>
@endpush

@push('css')

<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
    #force-responsive_wrapper {
        width: 100%;
    }

    #force-responsive_filter input {
        border: 0.5px solid #ced4da;
    }

    @media screen and (max-width: 520px) {
        table {
            width: 100% !important;
        }

        #force-responsive thead {
            display: none;
        }

        #force-responsive td {
            display: block;
            text-align: right;
            border-right: 1px solid #e1edff;
        }

        #force-responsive td::before {
            float: left;
            text-transform: uppercase;
            font-weight: bold;
            content: attr(data-header);
        }

        #force-responsive tr td:last-child {
            border-bottom: 2px solid #dddddd;
        }
    }
</style>
@endpush