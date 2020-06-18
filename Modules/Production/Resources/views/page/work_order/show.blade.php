@extends(Helper::setViewContent())
@component('component.mask', ['array' => ['number', 'money']])@endcomponent
@component('component.disable', ['array' => ['input', 'select'], 'selector' => '#transaction'])@endcomponent
@section('content')
<div class="row">
    {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel-body">
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">{{ ucwords(str_replace('_',' ',$template)) }} : {{ $model->$key }}</h2>
            </header>

            <div class="panel-body line">
                <div class="show">
                    <table class="table table-table table-bordered table-striped table-hover mb-none">
                        <tbody>
                            <tr>
                                <th class="col-lg-2">Sales Order</th>
                                <td>{{ $model->production_work_order_id }}</td>
                            </tr>
                            <tr>
                                <th class="col-lg-2">Sales Date</th>
                                <td>{{ $model->production_work_order_date->toDayDateTimeString() }}</td>
                            </tr>
                            <tr>
                                <th class="col-lg-2">Customer</th>
                                <td>{{ $model->vendor->production_vendor_name }}</td>
                            </tr>
                            <tr>
                                <th class="col-lg-2">Reference Order</th>
                                <td>{{ $model->sales_order->sales_order_id }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="{{ $action_function }}-table">
                    <div class="show">
                        @include($folder.'::page.'.$template.'.table')
                    </div>
                </div>

            </div>

        </div>
    </div>
    @include($folder.'::page.'.$template.'.action')
    {!! Form::close() !!}
</div>
@endsection