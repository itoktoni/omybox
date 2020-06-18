<div class="panel-body">
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title text-right">Process Split</h2>
        </header>
        <div class="panel-body line {{ $errors->has('hidden_product_id') ? 'has-error' : ''}}">
            <div class="col-md-12 col-lg-12">
                <div class="col-md-12">
                    <div style="margin-left:-30px;" class="form-group">
                        <table id="transaction" class="table table-no-more table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left" style="width:50px;">Index</th>
                                    <th class="text-left col-md-3">Vendor Name</th>
                                    <th class="text-left col-md-3">Product Name</th>
                                    <th class="text-right col-md-1">Sum</th>
                                    <th class="text-right col-md-2">Price</th>
                                    <th class="text-right col-md-1">Qty</th>
                                    <th class="text-right col-md-2">Total</th>
                                    <th class="text-right col-md-2">Default</th>
                                    <th class="text-right col-md-2">Process</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail as $item)
                                <tr>
                                    <td class="text-center" data-title="Index">

                                    </td>
                                    <td data-title="Vendor Name">

                                    </td>
                                    <td data-title="Product">
                                    </td>
                                    <td data-title="Sum" class=" text-right col-lg-1">
                                    </td>
                                    <td data-title="Price" class="text-right col-lg-1">
                                    </td>
                                    <td data-title="Qty" class="text-right col-lg-1">
                                    </td>
                                    <td data-title="Total" class="text-right col-lg-1">
                                    </td>
                                    <td data-title="Default" class=" text-right col-lg-1">
                                    </td>
                                    <td data-title="Process" class="text-right col-lg-1">
                                    </td>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>