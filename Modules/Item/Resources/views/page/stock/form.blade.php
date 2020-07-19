<div class="form-group">
<input type="hidden" value="0" name="{{ 'item_product_name' }}">
    {!! Form::label('name', 'Barcode', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'barcode') ? 'has-error' : ''}}">
        {!! Form::text($form.'barcode', $model->item_stock_barcode ?? $barcode, ['class' => 'form-control', 'readonly']) !!}
        {!! $errors->first($form.'barcode', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Item', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'product') ? 'has-error' : ''}}">
        {{ Form::select($form.'product', $product, null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'product', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Color', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'color') ? 'has-error' : ''}}">
        {{ Form::select($form.'color', $color, null, ['class'=> 'form-control option']) }}
        {!! $errors->first($form.'color', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Size', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'size') ? 'has-error' : ''}}">
        {{ Form::select($form.'size', $size, null, ['class'=> 'form-control option']) }}
        {!! $errors->first($form.'size', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

   {!! Form::label('name', 'Location', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'location') ? 'has-error' : ''}}">
        {{ Form::select($form.'location', $location, null, ['class'=> 'form-control option']) }}
        {!! $errors->first($form.'location', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Qty', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'qty') ? 'has-error' : ''}}">
        {!! Form::text($form.'qty', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'qty', '<p class="help-block">:message</p>') !!}
    </div>

</div>
