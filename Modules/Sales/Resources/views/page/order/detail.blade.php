<div class="panel-body {{ $errors->has('temp_id') ? 'has-error' : ''}}">
    <div class="panel panel-default">
        <div class="row">
            <div class="col-md-6">
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
                    <label class="col-md-2 control-label" for="inputDefault">Product</label>
                    <div class="col-md-4 {{ $errors->has('product') ? 'has-error' : ''}}">
                        <select class="form-control col-md-4" id="product" name="product">
                            <option value="">Select Product</option>
                            @foreach($product as $value)
                            @if ($value->item_product_discount_type)
                            @php
                            $harga = $value->item_product_discount_type == 1 ? $value->item_product_sell - ($value->item_product_discount_value * $value->item_product_sell) : $value->item_product_sell - $value->item_product_discount_value;
                            @endphp
                            <option value="{{ $value->item_product_id.'#'.floatval($harga) }}">
                                {{ $value->item_product_name }}
                            </option>
                            @else
                            <option value="{{ $value->item_product_id.'#'.floatval($value->item_product_sell) }}">
                                {{ $value->item_product_name }}
                            </option>
                            @endif
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
                <div class="form-group">
                    <label class="col-md-2 control-label" for="inputDefault">Notes</label>
                    <div class="col-md-10">
                        {!! Form::textarea('notes', null, ['id' => 'notes', 'class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                </div>
                @include($folder.'::page.'.$template.'.table')
            </div>
        </div>

    </div>
</div>

@push('javascript')
<script>
$(function() {

    $("#transaction").on('input', '.temp_qty', function() {
        var qty = $(this).val();
        var price = $(this).closest('tr').find('.temp_price');
        var total = $(this).closest('tr').find('.temp_total');

        var value_total = numeral(qty).value() * numeral(price.val()).value();
        total.val(numeral(value_total).format('0,0'));
        sumTotal();
    });

    $("#transaction").on('input', '.temp_price', function() {
        var price = $(this).val();
        var qty = $(this).closest('tr').find('.temp_qty');
        var total = $(this).closest('tr').find('.temp_total');

        var value_total = numeral(qty.val()).value() * numeral(price).value();
        total.val(numeral(value_total).format('0,0'));
        sumTotal();
    });

    $('#qty').keypress(function(e) {
        if (e.which == '13') {
            addDetail();
            e.preventDefault();
        }
    });

    $('#transaction').arrowTable();

    $('#price').keypress(function(e) {
        if (e.which == '13') {
            addDetail();
            e.preventDefault();
        }
    });
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var id = $(this).attr('value');
        $.alertable.confirm('Are You sure to delete ?').then(function(e) {
            if (typeof url !== typeof undefined && url !== false) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: 'POST',
                    success: function() {
                        $('.delete-' + id).closest("tr").remove();
                        sumTotal();
                    }
                });
            } else {
                $('button[value="' + id + '"]').parents("tr").remove();
                sumTotal();
            }
            $("#product").val('');
            $("#product").trigger("chosen:updated");
        }, function(x) {
            console.log('Confirmation canceled');
        });
    });

    $('#product').change(function() {
        var id = $("#product option:selected").val();
        var split = id.split("#");
        var product_id = split[0];
        var product_price = split[1];

        if (product_price == '') {

            new PNotify({
                title: 'Information Price !',
                text: 'Please Check Your Price Bahan !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });

            setTimeout(function() {
                $('#qty').focus();
            });
        } else {

            var price = $('input[name=price]');
            price.val(number_format(product_price));
            setTimeout(function() {
                $('#qty').focus();
                $('#qty').val(1);
                $('#min').val(1);
            });
            // qty.attr("placeholder", product_price).blur();

        }
    });

    $('#voucher').change(function() {
        sumTotal();
    });

    $("#add").click(function(e) {
        addDetail(e);
        e.preventDefault();
    });

    function sumTotal() {

        var sum = 0;
        $('.temp_total').each(function() {
            sum += numeral($(this).val()).value();
        });
        var total_name = $('#total_name');
        var total_value = $('#total_value');
        var total_input = $('#hidden_total');
        var total_product = $('#total_product');
        var total_payment = $('#total_payment');

        var voucher_code = $("#voucher option:selected").val();
        var voucher_name = $("#voucher option:selected").text();

        total_name.text('Total :');
        total_input.val(sum);
        total_value.text(numeral(sum).format('0,0'));
        total_product.val(numeral(sum).format('0,0'));
        total_payment.text(numeral(sum).format('0,0'));

        if (voucher_code != '') {

            var promo_code = $('.temp_promo_code');
            var promo_name = $('.temp_promo_name');
            var promo_value = $('.temp_promo_value');

            if (total_product.val() == '') {

                new PNotify({
                    title: 'Information Promo !',
                    text: 'Please Check Your Total !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });

            } else if (voucher_code == '') {

                new PNotify({
                    title: 'Information Promo !',
                    text: 'Please Check Your Promo !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });

            } else {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('promo_api') }}",
                    method: 'POST',
                    data: {
                        code: voucher_code,
                        value: total_input.val()
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.code == 0) {

                            new PNotify({
                                title: 'Information Promo !',
                                text: response.message,
                                addclass: 'notification-danger',
                                icon: 'fa fa-bolt'
                            });

                            $("#voucher").val('');
                            $("#voucher").trigger("chosen:updated");
                            promo_code.val('');
                            promo_name.val('');
                            promo_value.val('');
                            return false;
                        }

                        promo_code.val(voucher_code);
                        promo_name.val(voucher_name.trim());

                        promo_value.val(numeral(response.message).format('0,0'));
                        var total = numeral(total_input.val()).value() - numeral(response.message)
                            .value();
                        total_input.val(total);
                        total_value.text(numeral(total).format('0,0'));
                        total_payment.text(numeral(total).format('0,0'));
                    }
                });
            }
        }
    }

    function addDetail(e) {
        var input_qty = $('input[name=qty]');
        var input_price = $('input[name="price"]');
        var input_notes = $('#notes');
        var input_product = $('select[name="product"] option:selected');

        if (input_product.val() == '') {
            new PNotify({
                title: 'Error Select Product',
                text: 'You must select Product',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });

            return false;
        }

        var value_qty = input_qty.val();
        var notes = input_notes.val();
        var value_price = input_price.val();
        var product_value = input_product.val();
        var product_name = input_product.text().trim();

        var real_price = numeral(value_price).value();
        if (product_value) {

            var product_data = input_product.val();
            var split = product_data.split("#");
            var product_id = split[0];
            var product_price = numeral(split[1]).value();

            if (product_name) {

                var ep = document.getElementsByName('temp_id[]');
                for (i = 0; i < ep.length; i++) {
                    if (ep[i].value.trim() == product_id.trim()) {

                        new PNotify({
                            title: 'Product Already Exist',
                            text: 'Product ' + product_name.trim() + ' , Already in Table ',
                            addclass: 'notification-danger',
                            icon: 'fa fa-bolt'
                        });

                        return;
                    }
                }
                var total = numeral(real_price).value() * numeral(value_qty).value();
                var markup = "<tr><td data-title='Product'>" + product_name +
                    "</td><td data-title='Notes'><input class='form-control text-left' name='temp_notes[]' value='" +
                    notes +
                    "'></td><td data-title='Price' class='text-right col-lg-1'><input name='temp_price[]' readonly class='form-control text-right number temp_price' value='" +
                    real_price +
                    "'></td><td data-title='Qty' class='text-right col-lg-1'><input class='form-control text-right number temp_qty' name='temp_qty[]' value='" +
                    value_qty +
                    "'></td><td data-title='Total' class='text-right col-lg-1'><input type='text' name='temp_total[]' readonly class='form-control text-right money temp_total' value='" +
                    numeral(total).format('0,0') +
                    "'></td><td data-title='Action'><button id='delete' value='" + product_id +
                    "' type='button' class='btn btn-danger btn-block'>Delete</button></td><input type='hidden' value=" +
                    product_id + " name='temp_id[]'><input type='hidden' value='" + product_name +
                    "' name='temp_name[]'></tr>";
                $("table tbody").append(markup);
                sumTotal();
                maskNumber();
                $('input[name="price"]').val("");
                $('input[name="qty"]').val("");
                $('#notes').val("");

                $('input[name=price]').attr("placeholder", "").blur();
                $('input[name=qty]').attr("placeholder", "").blur();

                return false;
            } else {

                new PNotify({
                    title: 'Choose Product',
                    text: 'Please Select Product !',
                    addclass: 'notification-danger',
                    icon: 'fa fa-bolt'
                });
            }
        } else {
            new PNotify({
                title: 'Price and Quantity',
                text: 'Please Input Price & Quantity !',
                addclass: 'notification-danger',
                icon: 'fa fa-bolt'
            });
        }
    }
});
</script>
@endpush