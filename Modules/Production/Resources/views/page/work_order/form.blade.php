@component('component.date')
    
@endcomponent
<div id="input-form">
    <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">Work Order Date</label>
        <div class="col-md-4">
            <div class="input-group">
                {!! Form::text('production_work_order_date', $model->work_order_date ? $model->work_order_date->format('Y-m-d') : date('Y-m-d'), ['class' => 'date
                ', 'readonly'])
                !!}
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div>
        {!! Form::label('name', 'Reference Order', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('production_work_order_sales_order_id') ? 'has-error' : ''}}">
            {{ Form::select('production_work_order_sales_order_id', $order, null, ['id' => 'customer','class'=> 'form-control', 'data-plugin-selectTwo']) }}
            {!! $errors->first('production_work_order_sales_order_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" for="textareaDefault">Notes</label>
        <div class="col-md-4">
            {!! Form::textarea($form.'note', null, ['class' => 'form-control', 'rows' => '3']) !!}
        </div>

        {!! Form::label('name', 'Vendor', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('production_work_order_production_vendor_id') ? 'has-error' : ''}}">
            {{ Form::select('production_work_order_production_vendor_id', $vendor, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
            {!! $errors->first('production_work_order_production_vendor_id', '<p class="help-block">:message</p>') !!}
        </div>
        @isset($model->$key)

        <hr>
        {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            <input class="form-control" readonly value="{{ $model->status[$model->production_work_order_status][0] }}"
                type="text">
        </div>
        @endisset
    </div>
</div>