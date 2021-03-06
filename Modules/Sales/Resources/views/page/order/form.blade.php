@component('component.mask', ['array' => ['number', 'money']])
@endcomponent
@component('component.date', ['array' => ['date']])
@endcomponent
<div id="input-form">
    <div class="form-group">
        {!! Form::label('name', 'Order Date', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('sales_order_date', $model->sales_order_date ? $model->sales_order_date->format('Y-m-d') :
            date('Y-m-d'), ['class' => 'date'])
            !!}
        </div>
        {!! Form::label('name', 'Customer', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_rajaongkir_name') ? 'has-error' : ''}}">
            {!! Form::text('sales_order_rajaongkir_name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Order Email', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_email') ? 'has-error' : ''}}">
            {!! Form::text('sales_order_email', null, ['class' => 'form-control']) !!}
        </div>

        {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_rajaongkir_phone') ? 'has-error' : ''}}">
            {!! Form::text('sales_order_rajaongkir_phone', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">

        {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_status') ? 'has-error' : ''}}">
            {{ Form::select('sales_order_status', $status , null, ['class'=> 'form-control']) }}
            {!! $errors->first('sales_order_status', '<p class="help-block">:message</p>') !!}
        </div>

        <label class="col-md-2 control-label" for="textareaDefault">Notes</label>
        <div class="col-md-4">
            {!! Form::textarea($form.'rajaongkir_notes', null, ['class' => 'form-control', 'rows' => '3']) !!}
        </div>


    </div>
</div>
<hr>
<div id="input-form">
    <div class="form-group">
        {!! Form::label('name', 'Address', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::textarea('sales_order_rajaongkir_address', $model->sales_order_rajaongkir_address, ['class' =>
            'form-control', 'rows' => 5]) !!}
        </div>
        @if ($action_function == 'update')
        {!! Form::label('name', 'Paid', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('paid') ? 'has-error' : ''}}">
            {{ Form::select('paid', ['0' => 'NO', '1' => 'YES'] , null, ['class'=> 'form-control']) }}
            {!! $errors->first('paid', '<p class="help-block">:message</p>') !!}
        </div>
        @endif
    </div>
</div>

{!! Form::hidden('sales_order_id', $model->sales_order_id) !!}