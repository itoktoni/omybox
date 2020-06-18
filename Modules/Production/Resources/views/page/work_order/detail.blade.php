{!! Form::open(['route' => 'production_work_order_detail', 'class' => 'form-horizontal', 'files' => true]) !!}

<div class="panel-body {{ $errors->has('temp_id') ? 'has-error' : ''}}">
    <div class="panel panel-default">
        <div class="row">
            <div class="col-md-6">
                @if ($model->$key && !old('temp_id'))
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">Total</span> <span class="money"
                        id="total_value">{{ number_format($detail->sum('production_work_order_detail_total_order')) }}</span>
                    <input type="hidden" id="hidden_total"
                        value="{{ $detail->sum('production_work_order_detail_total_order') }}" name="total">
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
                    <button type="submit" id="add" class="btn btn-success detail">Add Detail</button>
                </h2>
            </div>
        </div>
        <div class="panel-body line">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Product</label>
                    <div class="col-md-4 {{ $errors->has('product') ? 'has-error' : ''}}">
                        <select data-plugin-selectTwo class="form-control col-md-4" id="product" name="product">
                            <option value="">Select Product</option>
                            @foreach($product as $value)
                            <option value="{{ $value->item_product_id.'#'.floatval($value->item_product_sell) }}">
                                {{ $value->item_product_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <label class="col-md-1 control-label" for="inputDefault">Price</label>
                    <div class="col-md-2">
                        {!! Form::text('price', null, ['id' => 'price', 'class' => 'money form-control']) !!}
                    </div>
                    <label class="col-md-1 control-label" for="inputDefault">Qty</label>
                    <div class="col-md-2">
                        {!! Form::text('qty', null, ['id' => 'qty', 'class' => 'number form-control']) !!}
                    </div>
                </div>
                @include($folder.'::page.'.$template.'.table')
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}