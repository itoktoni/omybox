<div class="panel-body {{ $errors->has('temp_id') ? 'has-error' : ''}}">
    <div class="panel panel-default">
        <div class="row">
            <div class="col-md-6">
                @if ($model->$key)
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">Total : </span> <span class="money"
                        id="total_value">{{ number_format($detail->sum('sales_order_detail_qty_prepare')) }}</span>
                    <input type="hidden" id="hidden_total" value="{{ $detail->sum('sales_order_detail_qty_prepare') }}"
                        name="total">
                </h2>
                @endif
            </div>
        </div>
        <div class="panel-body line">
            <div class="col-md-12 col-lg-12">
                @include($folder.'::page.'.$template.'.delivery_table')
            </div>
        </div>

    </div>
</div>