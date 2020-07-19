<div class="panel-body {{ $errors->has('temp_id') ? 'has-error' : ''}}">
    <div class="panel panel-default">
        <div class="row" style="clear:both;">
            <div class="col-md-6" style="clear:both;">
                @if ($model->$key && !old('temp_id'))
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">Total</span> <span class="money"
                        id="total_value">{{ number_format($detail->sum('sales_order_detail_total_order')) }}</span>
                    <input type="hidden" id="hidden_total" value="{{ $detail->sum('sales_order_detail_total_order') }}"
                        name="total">
                </h2>
                @else
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">{{ old('total') ? 'Total' : '' }}</span> <span class="money"
                        id="total_value">{{ old('total') ? number_format(old('total')) : '' }}</span>
                    <input type="hidden" id="hidden_total" value="{{ old('total') ? old('total') : 0 }}" name="total">
                </h2>
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="panel-title text-right">
                    <span id="add" class="btn btn-success detail">Add Detail</span>
                </h2>
            </div>
        </div>
        <div class="panel-body line">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Account</label>
                    <div class="col-md-3 {{ $errors->has('product') ? 'has-error' : ''}}">
                        {{ Form::select('account', $account, null, ['id' => 'account','class'=> 'form-control', 'data-plugin-selectTwo']) }}
                    </div>
                    <label class="col-md-1 control-label" for="inputDefault">Amount</label>
                    <div class="col-md-2">
                        {!! Form::text('amount', null, ['id' => 'amount', 'class' => 'money form-control']) !!}
                    </div>
                    <label class="col-md-1 control-label" for="inputDefault">File</label>
                    <div class="col-md-3">
                        <input type="file" name="{{ 'file' }}"
                            class="{{ $errors->has('file') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Bank</label>
                    <div class="col-md-3 {{ $errors->has('bank') ? 'has-error' : ''}}">
                        {{ Form::select('bank', $bank, null, ['id' => 'bank','class'=> 'form-control']) }}
                    </div>
                    <label class="col-md-1 control-label" for="textareaDefault">Notes</label>
                    <div class="col-md-6">
                        {!! Form::textarea($form.'note', null, ['class' => 'form-control', 'rows' => '3']) !!}
                    </div>
                </div>
                
                @include($folder.'::page.order.table_payment')
                
            </div>
        </div>

    </div>
</div>

@push('javascript')
<script>
    $(function() {

        $('#transaction').arrowTable();
    });
</script>
@endpush