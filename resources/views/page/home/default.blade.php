@extends(Helper::setExtendBackend())
@push('css')
<style>

    #transaction {
        font-size: 20px;
        border: 1.4px solid grey;    
    }

    #transaction td {
        border: 0.5px solid grey;
        font-size: 18px;
    }

    .even{
        background-color: ivory;
    }
</style>
@endpush
@section('content')
<div class="row">
    <div class="panel-body">

        <table id="transaction" style="margin-top: 0px !important" class="table table-no-more table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-left" style="width:100px;">No. Order</th>
                    @if (Auth::user()->group_user != 'partner')
                    <th class="text-left col-md-1">Brand</th>
                    @endif
                    <th class="text-left col-md-2">Product Name</th>
                    <th class="text-center col-md-1" style="width:50px;">Qty</th>
                    <th class="text-left col-md-2">Notes</th>
                    <th class="text-center col-md-1">Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($detail as $item)
                <tr class="{{ $loop->even ? 'even' : 'odd' }}">
                    <td data-title="No. Order">
                        {{ $item->sales_order_id }}
                    </td>
                    @if (Auth::user()->group_user != 'partner')
                    <td data-title="Outlet">
                        {{ $item->item_brand_name }}
                    </td>
                    @endif
                    <td data-title="Product">
                        {{ $item->item_product_name }}
                    </td>
                    <td data-title="Qty" align="center">
                        {{ $item->sales_order_detail_qty_order }}
                    </td>
                    <td data-title="Notes">
                        {{ empty($item->sales_order_detail_notes) ? '-' : $item->sales_order_detail_notes }}
                    </td>
                    <td data-title="Action" align="center">
                        <a href="{{ route('home', ['order' => $item->sales_order_id, 'id' => $item->item_product_id]) }}" class="btn btn-success btn-block">
                            Completed
                        </a>
                    </td>
                </tr>
                @endforeach
        </table>

    </div>
</div>
@endsection