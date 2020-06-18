@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
    <div class="panel-body">
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">{{ $model->item_product_name }}</h2>
            </header>

            <div class="panel-body line">
                <div class="show">
                    <table id="force-responsive" class="table table-table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Color</th>
                                <th scope="col">Size</th>
                                <th scope="col">Location</th>
                                <th scope="col">Warehouse</th>
                                <th scope="col">Created</th>
                                <th scope="col">Updated</th>
                                <th style="text-align:right" scope="col">Barcode</th>
                                <th style="text-align:right" scope="col">Stock</th>
                                <th style="text-align:right" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total = 0;
                            @endphp
                            @forelse ($stock as $item)
                            @php
                            $total = $total + $item->item_stock_qty;
                            @endphp
                            <tr>
                                <td data-header="Color">{{ $item->color->item_color_name ?? '' }}</td>
                                <td data-header="Size">{{ $item->item_stock_size }}</td>
                                <td data-header="Location">{{ $item->location->inventory_location_name ?? '' }}</td>
                                <td data-header="Warehouse">
                                    {{ $item->location->warehouse->inventory_warehouse_name ?? '' }}</td>
                                <td data-header="Created">{{ $item->item_stock_created_by ?? '' }}</td>
                                <td data-header="Updated">{{ $item->item_stock_updated_by ?? '' }}</td>
                                <td align="right" data-header="Barcode">{{ $item->item_stock_barcode }}</td>
                                <td align="right" data-header="Barcode">{{ number_format($item->item_stock_qty) }}</td>
                                <td align="right" data-header="Action">
                                    <a target="__blank" class="btn btn-danger btn-xs" href="{{ route($module.'_print_barcode', ['code' => $item->item_stock_barcode ]) }}">
                                        print
                                    </a>
                                    {{-- @if (Auth::user()->group_user == 'developer') --}}
                                    <a class="btn btn-primary btn-xs"
                                        href="{{ route($module.'_update', ['code' => $item->item_stock_id ]) }}">
                                        edit
                                    </a>
                                    {{-- @endif --}}
                                </td>
                            </tr>
                            @if ($loop->last)
                            <tr>
                                <td colspan="8" align="right"><strong>Total</strong></td>
                                <td align="right"><strong>{{ number_format($total) }}</strong></td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="8" align="center"><strong>No Stock Found</strong></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">
                    <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('css')
<style>
    @media screen and (max-width: 520px) {
        #force-responsive table.responsive {
            width: 100%;
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