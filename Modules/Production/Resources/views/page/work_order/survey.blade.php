@extends(Helper::setViewContent())
@livewireAssets(['base_url' => config('app.url')])
@section('content')
<div class="row">
    {!! Form::model($model, ['route'=>[$action_code, 'code' =>
    $model->production_work_order_detail_production_work_order_id, 'detail' =>
    $model->production_work_order_detail_item_product_id ],'class'=>'form-horizontal','files'=>true]) !!}
    <div class="panel-body">
        <div class="panel panel-default">
            <header class="panel-heading">
                <h2 class="panel-title">Survey Product : {{ $model->item_product_name }}</h2>
            </header>

            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">
                    <div id="input-form">

                        <div class="form-group">
                            <input type="hidden" value="{{ $model->production_work_order_detail_item_product_id }}"
                                name="production_work_order_detail_progress_item_product_id">

                            <label class="col-md-2 control-label" for="textareaDefault">Work Order</label>
                            <div class="col-md-4">
                                {!! Form::text('production_work_order_detail_progress_work_order_id',
                                $model->production_work_order_detail_production_work_order_id, ['class' =>
                                'form-control', 'readonly']) !!}
                            </div>

                            <label class="col-md-2 control-label" for="textareaDefault">Survey Date</label>
                            <div class="col-md-4">
                                <div class="input-group col-md-12">
                                    {!! Form::text('production_work_order_detail_progress_date', $model->production_work_order_detail_progress_date ?? date('Y-m-d'), ['class' => 'date
                                    form-control', 'readonly', 'data-plugin-datepicker'])
                                    !!}
                                   <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="textareaDefault">Status</label>
                            <div class="col-md-4">
                                {{ Form::select('production_work_order_detail_progress_status', Helper::shareStatus($status), null, ['id' => 'customer','class'=> 'form-control']) }}
                            </div>
                            <label class="col-md-2 control-label" for="textareaDefault">Notes</label>
                            <div class="col-md-4 {{ $errors->has('production_work_order_detail_progress_notes') ? 'has-error' : ''}}">
                                {!! Form::textarea('production_work_order_detail_progress_notes', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                {!! $errors->first('production_work_order_detail_progress_notes', '<p class="help-block">:message</p>') !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            
        </div>
        <div class="panel-default">

            <header class="panel-heading">
                <h2 class="panel-title">History Survey</h2>
            </header>

            <div class="panel-body line">
                <div class="col-md-12 col-lg-12">
                    @include($folder.'::page.'.$template.'.progress')
                </div>
            </div>
        </div>

    </div>
    @include($folder.'::page.'.$template.'.action')
    {!! Form::close() !!}
</div>

@endsection