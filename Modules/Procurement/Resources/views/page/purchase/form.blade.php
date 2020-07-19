@component('component.mask', ['array' => ['number', 'money']])
@endcomponent
@component('component.date', ['array' => ['date']])
@endcomponent

<div id="input-form">

    <div class="form-group">
        {!! Form::label('name', 'Order Date', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('purchase_date', $model->purchase_date ? $model->purchase_date->format('Y-m-d') :
            date('Y-m-d'), ['class' => 'date'])
            !!}
        </div>

        {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('purchase_status') ? 'has-error' : ''}}">
            {{ Form::select('purchase_status', $status , null, ['class'=> 'form-control']) }}
            {!! $errors->first('purchase_status', '<p class="help-block">:message</p>') !!}
        </div>

    </div>

    <div class="form-group">
        {!! Form::label('name', 'Vendor', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('purchase_procurement_vendor_id') ? 'has-error' : ''}}">
            {{ Form::select('purchase_procurement_vendor_id', $vendor , null, ['class'=> 'form-control']) }}
            {!! $errors->first('purchase_procurement_vendor_id', '<p class="help-block">:message</p>') !!}
        </div>

        {!! Form::label('name', 'Notes', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('purchase_notes') ? 'has-error' : ''}}">
            {!! Form::textarea('purchase_notes', null, ['class' => 'form-control', 'rows' => '3']) !!}
            {!! $errors->first('purchase_notes', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>