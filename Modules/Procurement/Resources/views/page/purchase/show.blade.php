@extends(Helper::setExtendBackend())
@component('component.mask', ['array' => ['number', 'money']])@endcomponent
@component('component.disable', ['array' => ['input', 'select'], 'selector' => '#transaction'])@endcomponent
@section('content')
<div class="row">
    {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal','files'=>true])
    !!}
    <div id="transaction" class="panel-body">
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">{{ ucwords(str_replace('_',' ',$template)) }} : {{ $model->$key }}</h2>
            </header>

            <div class="panel-body line">

                <div class="col-md-12 col-lg-12">
                    <div id="input-form">

                        <div class="form-group">
                            {!! Form::label('name', 'Order Date', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-4">
                                {!! Form::text('purchase_date', $model->purchase_date ?
                                $model->purchase_date->format('Y-m-d') :
                                date('Y-m-d'), ['class' => 'form-control'])
                                !!}
                            </div>

                            {!! Form::label('name', 'Vendor', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-4">
                                {!! Form::text('', $model->vendor->procurement_vendor_name, ['class' => 'form-control'])
                                !!}
                            </div>

                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'Notes', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-4 {{ $errors->has('purchase_notes') ? 'has-error' : ''}}">
                                {!! Form::textarea('purchase_notes', null, ['class' => 'form-control', 'rows' => '3'])
                                !!}
                                {!! $errors->first('purchase_notes', '<p class="help-block">:message</p>') !!}
                            </div>

                            {!! Form::label('name', 'Vendor Notes', ['class' => 'col-md-2 control-label']) !!}
                            <div class="col-md-4 {{ $errors->has('purchase_notes_vendor') ? 'has-error' : ''}}">
                                {!! Form::textarea('purchase_notes_vendor', null, ['class' => 'form-control', 'rows' => '3'])
                                !!}
                                {!! $errors->first('purchase_notes_vendor', '<p class="help-block">:message</p>') !!}
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    @include($folder.'::page.'.$template.'.table_payment')
    @include($folder.'::page.'.$template.'.action')
    {!! Form::close() !!}
</div>
@endsection