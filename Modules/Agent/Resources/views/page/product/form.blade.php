<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Slug', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'slug') ? 'has-error' : ''}}">
        {!! Form::text($form.'slug', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'slug', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Buying Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'buying') ? 'has-error' : ''}}">
        {!! Form::text($form.'buying', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'buying', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Selling Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'selling') ? 'has-error' : ''}}">
        {!! Form::text($form.'selling', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'selling', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Material', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'material_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'material_id', $material, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'material_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Unit', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'unit_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'unit_id', $unit, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'unit_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Category', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'category_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'category_id', $category, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'category_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Currency', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'currency_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'currency_id', $currency, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'currency_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'SKU', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'sku') ? 'has-error' : ''}}">
        {!! Form::text($form.'sku', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'sku', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Image', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'image') ? 'has-error' : ''}}">
        <input type="file" name="{{ $form.'image' }}" class="{{ $errors->has($form.'image') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
        {!! $errors->first($form.'image', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>