@extends(Helper::setExtendFrontend())

@component('component.mask', ['array' => ['number', 'money']])
@endcomponent
@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Your cart</h4>
		<div class="site-pagination">
			<a href="{{ config('app.url') }}">Home</a> /
			<a href="{{ route('cart') }}">Cart</a> /
			<a class="active" href="{{ route('checkout') }}">Checkout</a>
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- checkout section  -->
<section class="checkout-section spad">
	<div class="container">

		<div class="col-md-12 text-center">
			@if(session()->has('success'))
			<div style="margin-top:-20px;" class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil Dibuat, Segera lakukan Konfirmasi Pesanan !</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@endif


		</div>

		<div class="row">

			@if (Cart::getContent()->count() > 0)
			<div class="col-lg-4 order-1 order-lg-2">

				<div class="checkout-cart">
					<ul class="product-list">
						@php
						$total_gram = 0;
						@endphp
						@foreach (Cart::getContent() as $item_cart)
						@php
						$gram = $item_cart->quantity * $item_cart->attributes['gram'];
						$total_gram = $total_gram + $gram;
						@endphp
						<li>
							<div class="pl-thumb">
								<img src="{{ Helper::files('product/thumbnail_'.$item_cart->attributes['image']) }}"
									alt="{{ $item_cart->name }}">
							</div>
							<h6>{{ $item_cart->name }} {{ $item_cart->attributes['size'] }}
								{{ $item_cart->attributes['color'] }}</h6>
							<p>Qty : {{ number_format($item_cart->quantity) }}</p>
							<p>Price : {{ number_format($item_cart->price) }}</p>
							@if (config('website.tax'))
							<p>{{ $item_cart->getConditions()->getName() }} :
								{{ number_format(($item_cart->getConditions()->getValue() * $item_cart->quantity)) }}
							</p>
							@else
							<p>Weight : {{ number_format($gram) }}gr</p>
							@endif
							<p>Total :
								{{ config('website.tax') ? number_format(($item_cart->quantity * $item_cart->price) + ($item_cart->getConditions()->getValue() * $item_cart->quantity)) : number_format($item_cart->quantity * $item_cart->price) }}
							</p>
						</li>
						@endforeach
					</ul>
					<hr>
					<ul class="price-list">
						<li>Total Price
							<span id="calculate_total">{{ number_format(Cart::getSubTotal()) }}</span>
						</li>
						<li>Shipping
							<span id="calculate_shipping">0</span>
							<input type="hidden" value="0" id="shipping" name="shipping">
						</li>
						@if (Cart::getConditions()->count() > 0)
						<hr>
						<li>
							{{ Cart::getConditions()->first()->getAttributes()['name'] }}
							<span
								id="calculate_voucher">{{ number_format(Cart::getConditions()->first()->getValue()) }}</span>
						</li>
						@endif
						<hr>
						<input type="hidden" id="total" name="total">
						<li class="total">Total<span id="mask_total">{{ number_format(Cart::getTotal()) }}</span></li>
					</ul>
				</div>

				<div class="checkout-cart" style="margin-top:30px;">
					<ul class="product-list">

						@foreach ($account as $item_account)

						@if (!$loop->first)
						<hr style="margin-top:-10px;">
						@endif
						<li>
							<h6>{{ $item_account->finance_bank_name }}</h6>
							<p>Pemilik : {{ $item_account->finance_bank_account_name }}</p>
							<p>Rek Number : {{ $item_account->finance_bank_account_number }}</p>
						</li>

						@endforeach
					</ul>
				</div>
			</div>

			<div id="billing" class="col-lg-8 order-2 order-lg-1">

				{!!Form::open(['route' => 'checkout', 'class' => 'checkout-form', 'files' => true]) !!}
				<div class="cf-title">Billing Address : 
					<input type="hidden" value="{{ number_format($total_gram) }}" id="delivery">
				</div>
				<input type="hidden" id="weight" name="sales_order_rajaongkir_weight">
				<div class="row">
					<div class="col-md-2">
						<h5 class="text-right m-l-10">Province</h5>
					</div>
					<div class="col-md-4 {{ $errors->has('sales_order_rajaongkir_province_id') ? 'active' : ''}}">
						{{ Form::select("sales_order_rajaongkir_province_id", $list_province, $province , ['id' => 'province', 'class' => 'form-control chosen', 'data-placeholder' => 'Choose a Province']) }}
					</div>
					<div class="col-md-1">
						<h5 style="margin-left:-10px;" class="text-right">City</h5>
					</div>
					<div class="col-md-4 {{ $errors->has('sales_order_rajaongkir_city_id') ? 'active' : ''}}">
						{{ Form::select("sales_order_rajaongkir_city_id", $list_city, $city, ['id' => 'city', 'class' => 'form-control chosen', 'data-placeholder' => 'Choose a City']) }}
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h5 class="text-right m-l-10">Location </h5>
					</div>
					<div class="col-md-4 {{ $errors->has('sales_order_rajaongkir_area_id') ? 'active' : ''}}">
						{{ Form::select("sales_order_rajaongkir_area_id", $list_location, $location, ['id' => 'location', 'class' => 'form-control chosen', 'data-placeholder' => 'Choose a Location' ]) }}
					</div>

					<div class="col-md-1">
						<h5 class="text-right m-l-min-10">Courier</h5>
					</div>
					<div class="col-md-4 {{ $errors->has('sales_order_rajaongkir_courier') ? 'active' : ''}}">
						<input type="hidden" id="mask_courier" name="sales_order_rajaongkir_expedition">
						{{ Form::select("sales_order_rajaongkir_courier", $courier, null, ['id' => 'courier', 'class' => 'form-control chosen', 'data-placeholder' => 'Choose a Ongkir' ]) }}
					</div>

				</div>

				<div class="row">
					<div class="col-md-2">
						<h5 class="text-right m-l-10">Ongkir</h5>
					</div>
					<div class="col-md-9 {{ $errors->has('sales_order_rajaongkir_ongkir') ? 'active' : ''}}">
						<input type="hidden" id="mask_ongkir" name="sales_order_rajaongkir_service">
						{{ Form::select("sales_order_rajaongkir_ongkir", $ongkir, null, ['id' => 'ongkir', 'class' => 'form-control chosen', 'data-placeholder' => 'Choose a Ongkir']) }}
					</div>
				</div>

				<div class="row address-inputs">
					<div class="col-md-6">
						<input id="email" class="{{ $errors->has('sales_order_rajaongkir_postcode') ? 'error' : ''}}"
							name="sales_order_rajaongkir_postcode" type="text" value="{{ $postcode ?? null }}"
							placeholder="Postcode">
					</div>
					<div class="col-md-6">
						<input type="text" class="{{ $errors->has('sales_order_rajaongkir_name') ? 'error' : ''}}"
							name="sales_order_rajaongkir_name" value="{{ $name ?? null }}" placeholder="Name">
					</div>
					<div class="col-md-12">
						<input type="text" class="{{ $errors->has('sales_order_rajaongkir_address') ? 'error' : ''}}"
							name="sales_order_rajaongkir_address" value="{{ $address ?? null }}" placeholder="Address">
					</div>
					<div class="col-md-6">
						<input id="email" class="{{ $errors->has('sales_order_email') ? 'error' : ''}}"
							name="sales_order_email" type="text" value="{{ $email ?? null }}" placeholder="Email">
					</div>
					<div class="col-md-6">
						<input type="text" class="{{ $errors->has('sales_order_rajaongkir_phone') ? 'error' : ''}}"
							name="sales_order_rajaongkir_phone" value="{{ $phone ?? null }}" placeholder="Phone no.">
					</div>
				</div>

				<button type="submit" class="site-btn pull-right">Proceed to Order</button>

				{!! Form::close() !!}
			</div>
			@endif
		</div>
	</div>
</section>
<!-- checkout section end -->

@endsection

@push('javascript')

<script>
	$(document).ready(function() {

	var weight = numeral($('#delivery').val());
	$('#weight').val(weight.value());

	$('#province').change(function() { // Jika Select Box id provinsi dipilih
		var data = $("#province option:selected");
		var province = data.val(); // Ciptakan variabel provinsi
		var city = $('#city');
		$.ajax({
			type: 'GET', // Metode pengiriman data menggunakan POST
			url: '{{ route("city") }}',
			data: 'province=' + province, // Data yang akan dikirim ke file pemroses
			success: function(response) { // Jika berhasil
				city.empty();
				city.append('<option value=""></option>');
				$.each(response, function (idx, obj) {
					city.append('<option postcode="'+obj.rajaongkir_city_postal_code+'" value="' + obj.rajaongkir_city_id + '">' + obj.rajaongkir_city_name + '</option>');
				});
				city.trigger("chosen:updated");
			}
		});
	});

	$('#city').change(function() { // Jika Select Box id provinsi dipilih
		var data = $("#city option:selected");
		var city = data.val(); // Ciptakan variabel provinsi
		// var postcode = data.attr('postcode');
		var location = $('#location');
		// $('#postcode').val(postcode);
		$.ajax({
			type: 'GET', // Metode pengiriman data menggunakan POST
			url: '{{ route("location") }}',
			data: 'city=' + city, // Data yang akan dikirim ke file pemroses
			success: function(response) { // Jika berhasil
				location.empty();
				location.append('<option value=""></option>');
				$.each(response, function (idx, obj) {
					location.append('<option value="' + obj.rajaongkir_area_id + '">' + obj.rajaongkir_area_name + '</option>');
				});
				$("#location").trigger("chosen:updated");
			}
		});
	});

	$('#courier').change(function() { // Jika Select Box id provinsi dipilih
		var to = $("#location option:selected").val();
		var courier = $("#courier option:selected");
		var weight = parseFloat($('#delivery').val());
		var ongkir = $('#ongkir');
		var mask_courier = $('#mask_courier');
		mask_courier.val(courier.text());

		$.ajax({
			type: 'GET', // Metode pengiriman data menggunakan POST
			url: '{{ route("ongkir") }}',
			data: {'to':to, 'weight' : weight, 'courier' : courier.val()}, // Data yang akan dikirim ke file pemroses
			success: function(response) { // Jika berhasil
				ongkir.empty();
				if(Object.keys(response).length > 0){

				if(response[0].id){

					ongkir.append('<option value=""></option>');
					$.each(response, function (idx, obj) {
						ongkir.append('<option data="'+obj.cost+'" value="' + obj.service + '">' + obj.service + ' ( '+ obj.description + ' ) [ '+ obj.etd + ' ] - ' + obj.price+ ' </option>');
					});
				}
				else{
					console.log(response);
					ongkir.append('<option value="">'+response[0].text+'</option>');
				}
				
				ongkir.trigger("chosen:updated");
}

			}
		});
	});

	$('#ongkir').change(function() {
		
		var calculate_total = $('#calculate_total');
		var calculate_shipping = $('#calculate_shipping');
		var calculate_voucher = $('#calculate_voucher');
		var ongkir = $("#ongkir option:selected");

		var numeralTotal = numeral(calculate_total.text());
		var numeralVoucher = numeral(calculate_voucher.text());
		var numeralOngkir = numeral(ongkir.attr('data'));
				
		$('#mask_ongkir').val(ongkir.text());

		var sum = (numeralTotal.value() + numeralVoucher.value()) + numeralOngkir.value();
		var numeralSum = numeral(sum);
		$('#mask_total').text(numeralSum.format('0,0'));
		$('#total').val(numeralSum.value());

		$('#shipping').val(numeralOngkir.value());
		$('#calculate_shipping').text(numeralOngkir.format('0,0'));

	});
});
 
</script>

@endpush