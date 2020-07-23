<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

</div>
<hr>
<div class="form-group">

    {!! Form::label('name', 'Buy', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'buy') ? 'has-error' : ''}}">
        {!! Form::text($form.'buy', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'buy', '<p class="help-block">:message</p>') !!}
    </div>


    {!! Form::label('name', 'Sell', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'sell') ? 'has-error' : ''}}">
        {!! Form::text($form.'sell', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'sell', '<p class="help-block">:message</p>') !!}
    </div>



</div>



<div class="form-group">

    {!! Form::label('name', 'Unit Display', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'unit_display') ? 'has-error' : ''}}">
        {{ Form::select($form.'unit_display', $unit, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'unit_display', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Unit Stock', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'unit_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'unit_id', $unit, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'unit_id', '<p class="help-block">:message</p>') !!}
    </div>

</div>