<div class="form-group">

    {!! Form::label('name', 'Country Code', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'country_code') ? 'has-error' : ''}}">
        {!! Form::text($form.'country_code', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'country_code', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'country_name') ? 'has-error' : ''}}">
        {!! Form::text($form.'country_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'country_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Port Code', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'port_code') ? 'has-error' : ''}}">
        {!! Form::text($form.'port_code', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'port_code', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'country_name') ? 'has-error' : ''}}">
        {!! Form::text($form.'country_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'country_name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Code', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'lacode') ? 'has-error' : ''}}">
        {!! Form::text($form.'lacode', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'lacode', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

</div>