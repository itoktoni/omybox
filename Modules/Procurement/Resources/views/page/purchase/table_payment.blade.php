@push('style')
<style>
    .show-table table {
        width: 100%;
    }

    .show-table td[data-title="Action"],
    .show-table #action {
        display: none !important;
    }
</style>
@endpush

<div class="panel-body {{ $errors->has('temp_id') ? 'has-error' : ''}}">
    <div class="panel panel-default">
        <div class="row">
            <div class="col-md-6">
                @if ($model->$key && !old('temp_id'))
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">Total : </span> <span class="money"
                        id="total_value">{{ number_format($model->purchase_total_prepare) }}</span>
                    <input type="hidden" id="hidden_total" value="{{ $model->purchase_total_prepare }}" name="total">
                </h2>
                @endif
            </div>
        </div>
        <div class="panel-body line">
            <div class="col-md-12 col-lg-12">
                <table id="transaction" class="table table-no-more table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-md-2">Voucher</th>
                            <th class="text-left col-md-2">From</th>
                            <th class="text-left col-md-2">To</th>
                            <th class="text-left col-md-2">Receive</th>
                            <th class="text-right col-md-2">Message</th>
                            <th class="text-right col-md-3">Created Date</th>
                            <th class="text-right col-md-2">Created By</th>
                            <th class="text-right col-md-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($payment = $model->payment)
                        @foreach ($payment as $item)
                        <tr>
                            <td class="text-center" data-title="Voucher">
                                {{ $item->finance_payment_voucher }}
                            </td>
                            <td data-title="From">
                                {{ $item->finance_payment_from }}
                            </td>
                            <td data-title="To">
                                {{ $item->finance_payment_to }}
                            </td>
                            <td data-title="Receive">
                                {{ $item->finance_payment_person }}
                            </td>
                            <td data-title="Message" class="text-right col-lg-1">
                                {{ $item->finance_payment_description }}
                            </td>
                            <td data-title="Created At" class="text-right col-lg-2">
                                {{ $item->finance_payment_approved_at }}
                            </td>
                            <td data-title="Created By" class="text-right col-lg-1">
                                {{ $item->finance_payment_approved_by }}
                            </td>
                            <td data-title="Amount" class=" text-right col-lg-1">
                                {{ number_format($item->finance_payment_approve_amount) }}
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="7"><h5 class="text-right">Total</h5></td>
                            <td class="text-right">{{ number_format($payment->sum('finance_payment_approve_amount')) }}</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>