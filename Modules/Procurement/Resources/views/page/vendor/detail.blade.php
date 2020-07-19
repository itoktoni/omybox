<div class="panel-body">
    <div class="panel panel-default">
        <div class="row">
            <div class="col-md-6">
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name"></span> <span id="total_value"></span>
                </h2>
            </div>
            <div class="col-md-6">
                <h2 class="panel-title text-right">
                    <span id="add" class="btn btn-success detail">Add Detail</span>
                </h2>
            </div>
        </div>
        <div class="panel-body line {{ $errors->has('hidden_product_id') ? 'has-error' : ''}}">
            <div class="col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="col-md-1 control-label" for="inputDefault">Product</label>
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
                        {!! Form::text('price', null, ['id' => 'price', 'class' => 'number form-control']) !!}
                    </div>
                    <label class="col-md-1 control-label" for="inputDefault">Min</label>
                    <div class="col-md-1">
                        {!! Form::text('min', null, ['id' => 'min', 'class' => 'number form-control']) !!}
                    </div>
                    <label class="col-md-1 control-label" for="inputDefault">Max</label>
                    <div class="col-md-1">
                        {!! Form::text('max', null, ['id' => 'qty', 'class' => 'number form-control']) !!}
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
            
            $('#qty').keypress(function (e) {
                if (e.which == '13') {
                     addDetail();
                     e.preventDefault();
                }
            });

            $('#price').keypress(function (e) {
                if (e.which == '13') {
                     addDetail();
                     e.preventDefault();
                }
            }); 

            $(document).on('click', '#delete', function() {
                var id = $("#delete").val();
                $('button[value="' + id + '"]').parents("tr").remove();
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

                    setTimeout(function(){
                        $('#qty').focus();
                    });
                }
                else {
                    
                    var price = $('input[name=price]');
                    price.val(number_format(product_price));
                    setTimeout(function(){
                        $('#qty').focus();
                        $('#qty').val(1);
                        $('#min').val(1);
                    });
                    // qty.attr("placeholder", product_price).blur();

                }
            });
    
            $("#add").click(function(e) {
                addDetail(e);
                e.preventDefault();
            });
            
            function addDetail(e)
            {
                var input_min = $('input[name=min]');
                var input_max = $('input[name=max]');
                var input_price = $('input[name="price"]');
                var input_product = $('select[name="product"] option:selected');

                if(input_product.val() == ''){
                    new PNotify({
                        title: 'Error Select Product',
                        text: 'You must select Product',
                        addclass: 'notification-danger',
                        icon: 'fa fa-bolt'
                    });

                    return false;
                }

                var value_min = input_min.val();
                var value_max = input_max.val();
                var value_price = input_price.val();
                var product_value = input_product.val();
                var product_name = input_product.text().trim();
                
                var real_price = convertNumber(value_price);
                if (product_value) {

                    var product_data = input_product.val();
                    var split = product_data.split("#");
                    var product_id = split[0];
                    var product_price = convertNumber(split[1]);
    
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
                        var markup = "<tr><td data-title='ID Product'>" + product_id + "</td><td data-title='Product'>" + product_name + "</td><td data-title='Price' class='text-right col-lg-1'><input name='temp_price[]' class='form-control text-right number' value='" + real_price + "'></td><td data-title='Min Qty' class='text-right col-lg-1'><input class='form-control text-right number' name='temp_min[]' value='" + value_min + "'></td><td data-title='Max Qty' class='text-right col-lg-1'><input class='form-control text-right number' name='temp_max[]' value='" + value_max + "'></td><td data-title='Action'><button id='delete' value='" + product_id + "' type='button' class='btn btn-danger btn-xs btn-block'>Delete</button></td><input type='hidden' value=" + product_id + " name='temp_id[]'><input type='hidden' value='" + product_name + "' name='temp_name[]'></tr>";
                        $("table tbody").append(markup);
                        maskNumber();
                        $('input[name="price"]').val("");
                        $('input[name="min"]').val("");
                        $('input[name="max"]').val("");
    
                        $('input[name=price]').attr("placeholder", "").blur();
                        $('input[name=min]').attr("placeholder", "").blur();
                        $('input[name=max]').attr("placeholder", "").blur();

                        $('select[name="product"]').select2('open');
                        return false;
                    }
                    else {
    
                        new PNotify({
                            title: 'Choose Product',
                            text: 'Please Select Product !',
                            addclass: 'notification-danger',
                            icon: 'fa fa-bolt'
                        });
                    }
                }
                else {
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