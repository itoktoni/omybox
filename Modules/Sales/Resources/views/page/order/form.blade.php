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
            {!! Form::text('sales_order_rajaongkir_name', null, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Order Email', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_email') ? 'has-error' : ''}}">
            {!! Form::text('sales_order_email', null, ['class' => 'form-control', 'readonly']) !!}
        </div>

        {!! Form::label('name', 'Phone', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_rajaongkir_phone') ? 'has-error' : ''}}">
            {!! Form::text('sales_order_rajaongkir_phone', null, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" for="textareaDefault">Notes</label>
        <div class="col-md-4">
            {!! Form::textarea($form.'rajaongkir_notes', null, ['class' => 'form-control', 'rows' => '3', 'readonly']) !!}
        </div>

        {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_status') ? 'has-error' : ''}}">
            {{ Form::select('sales_order_status', $status , null, ['class'=> 'form-control']) }}
            {!! $errors->first('sales_order_status', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<hr>
<div id="input-form">
    <div class="form-group">
        {!! Form::label('name', 'Province', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('', $model->province->rajaongkir_province_name, ['class' => 'form-control', 'readonly']) !!}
        </div>
        {!! Form::label('name', 'City', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_rajaongkir_name') ? 'has-error' : ''}}">
            {!! Form::text('', $model->city->rajaongkir_city_name, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Area', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('', $model->area->rajaongkir_area_name, ['class' => 'form-control', 'readonly']) !!}
        </div>

        {!! Form::label('name', 'Postcode', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('', $model->sales_order_rajaongkir_postcode, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" for="textareaDefault">Address</label>
        <div class="col-md-10">
            {!! Form::textarea('', $model->sales_order_rajaongkir_address, ['class' => 'form-control', 'rows' => '3', 'readonly']) !!}
        </div>
    </div>
</div>
<hr>
<div id="input-form">
    <div class="form-group">
        {!! Form::label('name', 'Courier', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('', $model->sales_order_rajaongkir_expedition, ['class' => 'form-control', 'readonly']) !!}
        </div>
        {!! Form::label('name', 'Service', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('', $model->sales_order_rajaongkir_service, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Weight / gram', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('', $model->sales_order_rajaongkir_weight, ['class' => 'form-control', 'readonly']) !!}
        </div>

        {!! Form::label('name', 'Waybill', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('sales_order_rajaongkir_waybill', $model->sales_order_rajaongkir_waybill, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<hr>
<div id="input-form">
    <div class="form-group">
        {!! Form::label('name', 'Voucher Name', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('', $model->sales_order_marketing_promo_name, ['class' => 'form-control', 'readonly']) !!}
        </div>
        
        {!! Form::label('name', 'Voucher Value', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('', number_format($model->sales_order_marketing_promo_value), ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>
</div>

{!! Form::hidden('sales_order_id', $model->sales_order_id) !!}