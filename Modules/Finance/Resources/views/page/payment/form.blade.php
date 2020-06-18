@component('component.mask', ['array' => ['money']])
@endcomponent

@component('component.date', ['array' => ['date']])
@endcomponent

<div class="form-group">

    {!! Form::label('name', 'Payment Date', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        <div class="input-group">
            {!! Form::text($form.'date', $model->finance_payment_date ??
            date('Y-m-d'), ['class' => 'date
            form-control', 'readonly'])
            !!}
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>

    {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
        {{ Form::select($form.'status', $status, null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Order', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('finance_payment_sales_order_id') ? 'has-error' : ''}}">
        {{ Form::select('finance_payment_sales_order_id',$order, request()->get('so') ?? null, ['class'=> 'form-control' ,'id' => 'reference']) }}
        {!! $errors->first('finance_payment_sales_order_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Purchase', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('finance_payment_reference') ? 'has-error' : ''}}">
        {{ Form::select('finance_payment_reference', $purchase, request()->get('so') ?? null, ['class'=> 'form-control' ,'id' => 'reference']) }}
        {!! $errors->first('finance_payment_reference', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    @if ($action_function == 'update')
    {!! Form::label('name', 'Payment From', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text($form.'from', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::label('finance_payment_to', 'Bank Received', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('finance_payment_to') ? 'has-error' : ''}}">
        {{ Form::select('finance_payment_to',$bank, null, ['class'=> 'form-control' ,'id' => 'reference']) }}
        {!! $errors->first('finance_payment_to', '<p class="help-block">:message</p>') !!}
    </div>
    @else
    {!! Form::label('finance_payment_to', 'Payment From', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('finance_payment_from') ? 'has-error' : ''}}">
        {{ Form::select('finance_payment_from',$bank, null, ['class'=> 'form-control' ,'id' => 'reference']) }}
        {!! $errors->first('finance_payment_from', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Receiving Bank', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text($form.'to', null, ['class' => 'form-control']) !!}
    </div>

    @endif

</div>

<div class="form-group">
    {!! Form::label('name', 'Account', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('finance_payment_account_id') ? 'has-error' : ''}}">
        {{ Form::select('finance_payment_account_id', $account, null, ['class'=> 'form-control']) }}
        {!! $errors->first('finance_payment_account_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Reference Person', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text($form.'person', null, ['class' => 'form-control']) !!}
    </div>

</div>
<div class="form-group">

    {!! Form::label('name', 'Amount', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'amount') ? 'has-error' : ''}}">
        {!! Form::text($form.'amount', null, ['class' => 'form-control money', 'readonly']) !!}
        {!! $errors->first($form.'amount', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Amount Approve', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'approve_amount') ? 'has-error' : ''}}">
        {!! Form::text($form.'approve_amount', null, ['class' => 'form-control money']) !!}
        {!! $errors->first($form.'approve_amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Notes Customer', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'note') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'note', null, ['class' => 'form-control', 'rows' => '3', 'readonly']) !!}
        {!! $errors->first($form.'note', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description Admin', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'description') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first($form.'description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@if ($action['update'])

<div class="form-group">
    {!! Form::label('name', 'Order Paid', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'paid') ? 'has-error' : ''}}">
        {{ Form::select($form.'paid', ['0' => 'No', '1' => 'Yes'], null, ['class'=> 'form-control']) }}
    </div>

    <label class="col-md-2 control-label">File Attachment</label>
    <div class="col-md-2 {{ $errors->has('files') ? 'has-error' : ''}}">
        <a class="btn btn-success btn-sm btn-block" target="__blank"
            href="{{ Helper::files('payment/'.$model->finance_payment_attachment) }}">Download</a>
    </div>
    @if ($model->finance_payment_approved_at)
    <div class="col-md-2 {{ $errors->has('files') ? 'has-error' : ''}}">
        <a class="btn btn-danger btn-sm btn-block" target="__blank"
            href="{{ route($module.'_print_voucher', ['code' => $model->finance_payment_id]) }}">PRINT VOUCHER</a>
    </div>
    @endif

    @if ($model->order)
    <div class="col-md-6">
        <h2>Total Order : {{ $model->order ? number_format($model->order->sales_order_total) : 0 }}</h2>
    </div>
    @endif
</div>
@endif