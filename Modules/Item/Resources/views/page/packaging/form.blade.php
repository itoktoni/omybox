<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Item', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_id', $item, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_id', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Package Qty', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'qty_to') ? 'has-error' : ''}}">
        {!! Form::text($form.'qty_to', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'qty_to', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Package', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'unit_to') ? 'has-error' : ''}}">
        {{ Form::select($form.'unit_to', $unit, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'unit_to', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Unit Qty', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'qty_from') ? 'has-error' : ''}}">
        {!! Form::text($form.'qty_from', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'qty_from', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Unit', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has($form.'unit_from') ? 'has-error' : ''}}">
            {{ Form::select($form.'unit_from', $unit, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
            {!! $errors->first($form.'unit_from', '<p class="help-block">:message</p>') !!}
        </div>

</div>
