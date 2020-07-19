<table id="barcode" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-2">Barcode</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-right col-md-1">Size</th>
            <th class="text-right col-md-1">Color</th>
            <th class="text-right col-md-1">Qty</th>
            <th id="action" class="text-center col-md-1">Action</th>
        </tr>
    </thead>
    <tbody>
        @if($stock && !old('temp_id'))
        @foreach ($stock as $item)
        <tr>
            <td data-title="ID Product">
                {{ $item->item_stock_option }}
            </td>
            <td data-title="Product">
                {{ $item->product->item_product_name }}
            </td>
            <td data-title="Size" class="text-right col-lg-1">
                {{ $item->item_stock_size }}
            </td>
            <td data-title="Color" class="text-right col-lg-1">
                {{ $item->color->item_color_name }}
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                {{ $item->item_stock_qty }}
            </td>
            <td class="text-center" style="text-align: center;" data-title="Action">
                <input type="checkbox" name="temp_id[]" value="{{ $item->item_stock_barcode }}" total="{{ $item->item_stock_qty }}"
                    class="tick">
            </td>
        </tr>
        @endforeach
        @endif
        @if(old('temp_id'))
        @foreach (old('temp_id') as $product)
        <tr>
            <td data-title="ID Product">
                {{ $product }}
                <input type="hidden" value="{{ $product }}" name="temp_id[]">
            </td>
            <td data-title="Product">
                {{ old('temp_name')[$loop->index] }}
                <input type="hidden" name="temp_name[]" value="{{ old('temp_name')[$loop->index] }}" </td> <td
                    data-title="Price" class="text-right col-lg-1">
                <input type="text" name="temp_price[]" class="form-control text-right number temp_price"
                    value="{{ old('temp_price')[$loop->index] }}">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" class="form-control text-right number temp_qty"
                    value="{{ old('temp_qty')[$loop->index] }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="temp_total[]" class="form-control text-right number temp_total"
                    value="{{ old('temp_total')[$loop->index] }}">
            </td>
            <td data-title="Action">
                @if ($model->$key && $detail->contains('item_product_id', $product))
                <a id="delete" value="{{ $product }}"
                    href="{{ route(config('module').'_delete', ['code' => $model->production_vendor_id, 'detail' => $product ]) }}"
                    class="btn btn-danger btn-block delete-{{ $product }}">Delete</a>
                @else
                <button id="delete" value="{{ $product }}" type="button"
                    class="btn btn-danger btn-block">Delete</button>
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

@push('javascript')
<script>
    $(function() {
        sumTotal();

        $('#barcode :checkbox').change(function() {
            // this will contain a reference to the checkbox
            if (this.checked) {
            // the checkbox is now checked
                sumTotal($(this).attr('total'));

            } else {
            // the checkbox is now no longer checked
                minTotal($(this).attr('total'));
            }
        });

        $("#transaction").on('input', '.temp_qty', function () {
            var qty=$(this).val();
            var price = $(this).closest('tr').find('.temp_price');
            var total = $(this).closest('tr').find('.temp_total');
            
            var value_total = numeral(qty).value() * numeral(price.val()).value();
            total.val(numeral(value_total).format('0,0'));
            sumTotal();
        });

        $("#transaction").on('input', '.temp_price', function () {
            var price = $(this).val();
            var qty = $(this).closest('tr').find('.temp_qty');
            var total = $(this).closest('tr').find('.temp_total');
            
            var value_total = numeral(qty.val()).value() * numeral(price).value();
            total.val(numeral(value_total).format('0,0'));
            sumTotal();
        });

        $('#qty').keypress(function (e) {
            if (e.which == '13') {
                addDetail();
                e.preventDefault();
            }
        });

        $('#transaction').arrowTable();

        $('#price').keypress(function (e) {
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
                if(typeof url !== typeof undefined && url !== false){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        method : 'POST',
                        success: function (){
                            $('.delete-'+id).closest("tr").remove();
                            sumTotal();
                        }
                    });
                }
                else{
                    $('button[value="' + id + '"]').parents("tr").remove();                    
                    sumTotal();
                }
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

        function sumTotal(total = false){

            var total_name = $('#total_name');
            var total_value = $('#total_value');
            var total_input = $('#hidden_total');
            var sum = numeral(total_input.val());
            sum = sum.value() + numeral(total).value();
            console.log(sum);

            total_name.text('Total :');
            total_input.val(sum);
            total_value.text(numeral(sum).format('0,0'));
        }

        function minTotal(total = false){

            var total_name = $('#total_name');
            var total_value = $('#total_value');
            var total_input = $('#hidden_total');
            var sum = numeral(total_input.val());
            sum = sum.value() - numeral(total).value();

            total_name.text('Total :');
            total_input.val(sum);
            total_value.text(numeral(sum).format('0,0'));
        }
        
        function addDetail(e)
        {
            var input_qty = $('input[name=qty]');
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

            var value_qty = input_qty.val();
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
                    var markup = "<tr><td data-title='ID Product'>" + product_id + "</td><td data-title='Product'>" + product_name + "</td><td data-title='Price' class='text-right col-lg-1'><input name='temp_price[]' class='form-control text-right number temp_price' value='" + real_price + "'></td><td data-title='Qty' class='text-right col-lg-1'><input class='form-control text-right number temp_qty' name='temp_qty[]' value='" + value_qty + "'></td><td data-title='Total' class='text-right col-lg-1'><input type='text' name='temp_total[]' readonly class='form-control text-right money temp_total' value='" + numeral(total).format('0,0') + "'></td><td data-title='Action'><button id='delete' value='" + product_id + "' type='button' class='btn btn-danger btn-block'>Delete</button></td><input type='hidden' value=" + product_id + " name='temp_id[]'><input type='hidden' value='" + product_name + "' name='temp_name[]'></tr>";
                    $("table tbody").append(markup);
                    sumTotal();
                    maskNumber();
                    $('input[name="price"]').val("");
                    $('input[name="qty"]').val("");

                    $('input[name=price]').attr("placeholder", "").blur();
                    $('input[name=qty]').attr("placeholder", "").blur();

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