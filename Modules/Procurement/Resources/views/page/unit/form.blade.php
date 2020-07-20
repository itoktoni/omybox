<div class="form-group">

    {!! Form::label('name', 'Code', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'code') ? 'has-error' : ''}}">
        {!! Form::text($form.'code', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'code', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Operator', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'operator') ? 'has-error' : ''}}">
        {{ Form::select($form.'operator', $operator, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'operator', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Value', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'value') ? 'has-error' : ''}}">
        {!! Form::text($form.'value', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'value', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

</div>