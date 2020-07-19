@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Your cart</h4>
		<div class="site-pagination">
			<a href="{{ config('app.url') }}">Home</a> /
			<a href="{{ route('cart') }}">Your cart</a>
		</div>
	</div>
</div>
<!-- Page info end -->
<!-- cart section end -->
<section class="cart-section spad">
	<div class="container">
		<div class="col-md-5 pull-right">
			@if ($errors)
			@foreach ($errors->all() as $error)
			<div style="margin-top:-20px;" class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>{{ $error }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			@endforeach
			@endif
		</div>
		@if (Cart::getContent()->count() > 0)
		<div class="row clearfix" style="clear: both;">
			{!!Form::open(['route' => 'cart', 'class' => 'header-search-form', 'files' => true]) !!}
			<div class="col-lg-12">
				<div class="cart-table">
					<div class="cart-table-warp">
						<table>
							<thead>
								<tr>
									<th class="quy-th">
										<h5>Image</h5>
									</th>
									<th class="product-th">
										<h5 style="margin-left:20px;">Product</h5>
									</th>
									<th class="quy-th">
										<h5>Qty</h5>
									</th>
									<th class="size-th">
										<h5 class="text-right">Price</h5>
									</th>
									<th class="size-th">
										<h5 class="text-right" style="margin-right:20px;">Total</h5>
									</th>
									<th class="total-th">
										<h5 class="text-right">Action</h5>
									</th>
								</tr>
							</thead>
							<tbody>
								@if (!Cart::isEmpty())
								@foreach (Cart::getContent() as $item_cart)
								<tr id="render"
									class="{{ $errors->has("cart.$loop->index.qty") ? 'border-error' : '' }}">
									<td class="total-col">
										<img src="{{ Helper::files('product/thumbnail_'.$item_cart->attributes['image']) }}"
											alt="{{ $item_cart->name }}">
									</td>
									<td class="product-col" style="margin-right:20px;margin-left:20px;">
										<div style="margin-top:50px;">
											<h4 class="text-left">
												<a class="text-secondary" style="font-size:15px;"
													href="{{ route('single_product', ['slug' => Str::slug($item_cart->name)]) }}">
													{{ $item_cart->name}} {{ $item_cart->attributes['size'] }}
													{{ $item_cart->attributes['color'] }}
												</a>
											</h4>
										</div>
									</td>
									<td class="quy-col">
										<div class="quantity">
											<div class="pro-qty">
												<input id="qty" class="qty" name="cart[{{$loop->index}}][qty]"
													type="text"
													value="{{ old("cart[$loop->index][qty]") ?? $item_cart->quantity }}">
												<input type="hidden" id="idproduct"
													value="{{ $item_cart->attributes['option'] }}"
													name="cart[{{ $loop->index }}][option]">
											</div>
										</div>
									</td>
									<td class="size-col">
										<h4 class="text-right">

											<p style="margin-top:0px;margin-bottom:0px;">
												{{ number_format($item_cart->price) }}</p>
											@if (config('website.tax') && !empty($item_cart->getConditions()))
											<p style="margin-bottom:0px;">
												+
												{{ number_format($item_cart->getConditions()->getValue() * $item_cart->quantity) }}
												{{ $item_cart->getConditions()->getName() }}
											</p>
											@endif
										</h4>
									</td>
									<td class="size-col">
										<div style="margin-right:20px;">
											<h4 class="text-right">
												{{ config('website.tax') && $item_cart->getConditions() ? number_format(($item_cart->quantity * $item_cart->price) + ($item_cart->getConditions()->getValue() * $item_cart->quantity)) : number_format($item_cart->quantity * $item_cart->price) }}
											</h4>
										</div>
									</td>

									<td class="size-col">
										<a onclick="return confirm('Are you sure to delete product ?');"
											class="btn btn-danger btn-xs pull-right"
											href="{{ route('delete', ['id' => $item_cart->id ]) }}">Delete</a>
									</td>
								</tr>
								@endforeach
								@endif
								@if (Cart::getConditions()->count() > 0)
								<tr>
									<td class="total-col" colspan="5" style="border-top:1px solid #f51167;">
										<h4 style="margin-top:20px;float:left;">
											Redem Discount :
											{{ Cart::getConditions()->first()->getAttributes()['name'] }}
										</h4>
										<h4 style="margin-top:20px;float:right">
											{{ number_format(Cart::getConditions()->first()->getValue()) }}
										</h4>
									</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div class="total-cost">
						<h6>Total <span>{{ number_format(Cart::getTotal()) }}</span></h6>
					</div>
				</div>
			</div>

			<div style="margin-top:20px;" class="col-lg-12 card-right">
				{!! Form::close() !!}

				<div class="row">
					<div class="col-md-4 col-sm-12 col-sx-12"></div>
					<div class="col-md-5 col-sm-12 col-sx-12 promo-code-form">
						{!! Form::open(['route' => 'cart', 'class' => 'promo-code-form', 'files' => true]) !!}
						<input type="text" name="code" value="{{ old('code') ?? null }}" placeholder="Enter promo code">
						<button type="submit">Submit</button>
						{!! Form::close() !!}
					</div>
					<div class="col-md-3 col-sm-12 col-sx-12">
						<a class="site-btn sb-dark pull-right" href="{{ route('checkout') }}">Checkout</a>
					</div>
				</div>

			</div>

		</div>
	</div>
	@else
	<div class="col-lg-12 card-right">
		<div class="row">
			<a href="{{ route('shop') }}" class="site-btn">Go to list catalog </a>
		</div>
	</div>
	@endif
	</div>
</section>

@endsection

@push('javascript')

<script>
	// $(document).on('click', '.add-card', function() {
	// 	var product = $(this).attr('alt');
	// 	$.notiny({ text: 'ADD '+product, position: 'right-top' });
	// });

	 /*-------------------
    	Quantity change
    --------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function() {
		var $button = $(this);
		var oldValue = $button.parent().find('#qty').val();
		var idproduct = $button.parent().find('#idproduct').val();
		if ($button.hasClass('inc')) {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 1) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 1;
			}
		}
		var setnumber;
		$.ajax({
			type: 'POST', // Metode pengiriman data menggunakan POST
			url: '{{ route("update_cart") }}',
			data: { 'product': idproduct+'', 'qty': newVal, '_token' : "{{ csrf_token() }}" }, // Data yang akan dikirim ke file pemroses
				success: function(response) { // Jika berhasil
				if(response['status'] == false){
					$.notiny({ text: response['error'], position: 'right-top' });
					$button.parent().find('#qty').val(oldValue);
				}
				else{
					$button.parent().find('#qty').val(newVal);
				}
			}
		});

		// $button.parent().find('#qty').val(setnumber);
		// return false;
		// setTimeout(function(){
		// location.reload();
		// }, 100);
	});


	$(".qty").change(function(el) {

		var idproduct = $(this).parent().find('#idproduct').val();
		var newVal = el.target.value;
		var setnumber;
		if(typeof idproduct !== 'undefined'){

		$.ajax({
			type: 'POST', // Metode pengiriman data menggunakan POST
			url: '{{ route("update_cart") }}',
			data: { 'product': idproduct+'', 'qty': newVal, '_token' : "{{ csrf_token() }}" }, // Data yang akan dikirim ke file pemroses
				success: function(response) { // Jika berhasil
				if(response['status'] == false){
					var inputQty = $(this).parent().find('.qty');
					inputQty.attr('value', response['number']);
					$.notiny({ text: response['error'], position: 'right-top' });
					setTimeout(function(){
					location.reload();
					}, 2000);
					return true;
				}
				else{
					setTimeout(function(){
					location.reload();
					}, 100);
				}
			}
		});
}

	});

	


</script>

@endpush