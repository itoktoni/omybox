

<div class="form-group">

    {!! Form::label('name', 'Unit From', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'from') ? 'has-error' : ''}}">
        {{ Form::select($form.'from', $unit, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'from', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Convert To', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'to') ? 'has-error' : ''}}">
        {{ Form::select($form.'to', $unit, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'to', '<p class="help-block">:message</p>') !!}
    </div>


</div>

<div class="form-group">

    {!! Form::label('name', 'Value In Stock', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'value') ? 'has-error' : ''}}">
        {!! Form::text($form.'value', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'value', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

</div>