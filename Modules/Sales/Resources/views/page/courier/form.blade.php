<div class="form-group">

    {!! Form::label('name', 'Code', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('rajaongkir_courier_code') ? 'has-error' : ''}}">
        {!! Form::text('rajaongkir_courier_code', null, ['class' => 'form-control']) !!}
        {!! $errors->first('rajaongkir_courier_code', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('rajaongkir_courier_code') ? 'has-error' : ''}}">
        {!! Form::text('rajaongkir_courier_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('rajaongkir_courier_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">
    {!! Form::label('name', 'Active', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('rajaongkir_courier_active') ? 'has-error' : ''}}">
        {{ Form::select('rajaongkir_courier_active', [1 => 'Yes', 0 => 'No'], null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first('rajaongkir_courier_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>