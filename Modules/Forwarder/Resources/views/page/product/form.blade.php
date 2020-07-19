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

    {!! Form::label('name', 'Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'price') ? 'has-error' : ''}}">
        {!! Form::text($form.'price', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'price', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Tax', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'tax_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'tax_id', $tax, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'tax_id', '<p class="help-block">:message</p>') !!}
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
    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>
</div>