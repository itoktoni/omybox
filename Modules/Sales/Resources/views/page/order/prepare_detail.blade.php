<div class="panel-body {{ $errors->has('temp_id') ? 'has-error' : ''}}">
    <div class="panel panel-default">

        <div class="panel-body line">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            @if ($model->$key && !old('temp_id'))
                            <h2 id="total" class="panel-title text-left">
                                <span id="total_name">Total : </span> <span class="money" id="total_value"></span>
                                <input type="hidden" id="hidden_total" value="" name="total">
                            </h2>
                            @else
                            <h2 id="total" class="panel-title text-left">
                                <span id="total_name">{{ old('total') ? 'Total' : '' }}</span> <span class="money"
                                    id="total_value">{{ old('total') ? number_format(old('total')) : '' }}</span>
                                <input type="hidden" id="hidden_total" value="{{ old('total') ? old('total') : 0 }}" name="total">
                            </h2>
                            @endif
                        </div>
                    </div>
                </div>
                @include($folder.'::page.'.$template.'.prepare_table')
            </div>
        </div>

    </div>
</div>
