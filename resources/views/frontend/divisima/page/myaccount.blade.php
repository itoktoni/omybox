@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Personal Data</h4>
		<div class="site-pagination">
			<a href="{{ Helper::base_url() }}">Home</a> |
			<a href="{{ route('about') }}">About</a>
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- product section -->
<section class="product-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 product-details">

				@if (session()->has('info'))
				<div style="margin-top:-20px;" class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>{{ session()->get('info') }}</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif

				<div class="panel">
					<div aria-labelledby="headingOne" data-parent="#accordion">
						<div class="panel-body">
							<div class="accordion" id="accordionExample">
								<div class="card">
									<div class="card-header" id="headingTwo">
										<h2 class="mb-0">
											<button class="btn btn-link collapsed " type="button" data-toggle="collapse"
												data-target="#collapseTwo" aria-expanded="false"
												aria-controls="collapseTwo">
												List Data [ sales order ]
											</button>
										</h2>
									</div>
									<div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
										data-parent="#collapseTwo">
										<div class="card-body">
											<table id="force-responsive" class="table table-table table-bordered">
												<thead>
													<tr>
														<th scope="col">No. Order</th>
														<th scope="col">Date</th>
														<th scope="col">Name</th>
														<th style="width:70px;" scope="col">Email</th>
														<th style="text-align:right" scope="col">Total</th>
														<th style="text-align:right" scope="col">Status</th>
														<th style="text-align:center" scope="col">Resi</th>
														<th style="text-align:center;width:100px;" scope="col">
															Detail</th>
													</tr>
												</thead>
												<tbody>
													@forelse ($order as $item)
													<tr style="position:relative">
														<td data-header="Order No.">
															<button type="button"
																class="btn btn-primary btn-block btn-sm"
																data-toggle="modal"
																data-target="#{{ $item->sales_order_id ?? '' }}">
																{{ $item->sales_order_id ?? '' }}
															</button>
														</td>
														<td data-header="Order Date">
															{{ $item->sales_order_date->format('d M y') }}
														</td>
														<td data-header="Ongkir">
															{{ $item->sales_order_rajaongkir_name ?? '' }}
														</td>
														<td data-header="Email">
															{{ $item->sales_order_email ?? '' }}
														</td>
														<td data-header="Total" align="right">
															{{ number_format($item->sales_order_total) ?? '' }}
														</td>
														<td data-header="Status" align="right">
															{{ $status[$item->sales_order_status] ?? '' }}
														</td>
														<td data-header="Courier" align="center">
															{{ strtoupper($item->sales_order_rajaongkir_courier) ?? '' }}
														</td>
														<td data-header="Detail" align="center">
															@if ($item->sales_order_status < 2 || $item->sales_order_status == 0)
															<a href="{{ route('confirmation', ['code' => $item->sales_order_id]) }}"
																class="btn btn-success btn-sm">
																Pay
															</a>
															@endif
															@if ($item->sales_order_rajaongkir_waybill)
															<a id="track" target="__blank"
																href="{{ route('track', ['code' => $item->sales_order_id]) }}"
																class="btn btn-danger btn-sm">
																Track
															</a>
															@endif
														</td>

													</tr>
													<!-- Modal Order -->
													<div class="modal fade" id="{{ $item->sales_order_id ?? '' }}"
														tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
														aria-hidden="true">
														<div class="modal-dialog modal-lg" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="exampleModalLabel">No.
																		Order :
																		{{ $item->sales_order_id ?? '' }}
																	</h5>
																	<button type="button" class="close"
																		data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">

																	<ul class="list-group">
																		@if ($item->detail->count() > 0)
																		@foreach ($item->detail as $detail)
																		<li
																			class="list-group-item d-flex justify-content-between align-items-center">

																			{{ $detail->product->item_product_name ?? '' }}
																			{{ $detail->sales_order_detail_item_size ?? '' }}
																			{{ $detail->color->item_color_name ?? '' }}
																			<br>
																			[
																			{{ $detail->sales_order_detail_qty_order }}
																			pcs *
																			{{ number_format($detail->sales_order_detail_price_order) }}
																			]
																			@if (config('website.tax'))
																			<br>
																			VAT
																			{{ $detail->sales_order_detail_tax_name }}
																			:
																			{{ number_format($detail->sales_order_detail_tax_value) }}
																			@endif
																			<span>{{ number_format($detail->sales_order_detail_total_order) }}</span>
																		</li>
																		@endforeach
																		@endif
																		<li
																			class="list-group-item d-flex justify-content-between align-items-center">
																			{{ $item->sales_order_rajaongkir_service }}
																			<span>{{ number_format($item->sales_order_rajaongkir_ongkir) }}</span>
																		</li>
																	</ul>
																</div>
																<div class="modal-footer">
																	<div class="row">
																		<div
																			style="position:absolute;bottom:20px;left:20px;">
																			Voucher
																			{{ $item->sales_order_marketing_promo_name }}
																			:
																			-
																			{{ number_format($item->sales_order_marketing_promo_value) ?? '' }}
																		</div>
																		<div class="pull-right"
																			style="margin-left:5px;margin-right:30px;">
																			Total :
																			{{ number_format($item->sales_order_total) ?? '' }}
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!-- end modal order -->

													@empty
													<tr>
														<td colspan="7" data-header="Empty Order">
															Empty Order
														</td>
													</tr>
													@endforelse
												</tbody>
											</table>
										</div>
									</div>
								</div>
								
								<div class="card">
									<div class="card-header" id="headingThree">
										<h2 class="mb-0">
											<button class="btn btn-link collapsed" type="button" data-toggle="collapse"
												data-target="#collapseThree" aria-expanded="false"
												aria-controls="collapseThree">
												Wish List [ loved product ]
											</button>
										</h2>
									</div>
									<div id="collapseThree" class="collapse {{ request()->get('page') ? 'show' : '' }}"
										aria-labelledby="headingThree" data-parent="#collapseThree">
										<div class="card-body">
											<div class="row">
												@foreach ($my_wishlist as $item_product)
												<div class="col-lg-2 col-sm-3">
													<div class="product-item">

														<div class="pi-pic">
															@if($item_product->item_product_flag)
															<div class="tag-sale">
																{{ $item_product->item_product_flag }}</div>
															@endif
															<a
																href="{{ route('single_product', ['slug' => $item_product->item_product_slug]) }}">
																<img src="{{ Helper::files('product/'.$item_product->item_product_image) }}"
																	alt="{{ $item_product->item_product_name }}">
															</a>
														</div>

														<div style="margin-top:10px;" class="col-md-12">
															@if ($item_product->item_product_discount_type)
															<h6 class="coret row">
																{{ number_format($item_product->item_product_sell) }}
															</h6>
															<h6 class="text-right"
																style="position:absolute;top:0px;right:0px;">
																{{ number_format($item_product->item_product_discount_type == 1 ? $item_product->item_product_sell - ($item_product->item_product_discount_value * $item_product->item_product_sell) : $item_product->item_product_sell - $item_product->item_product_discount_value ) }}
															</h6>
															@else
															<h6 class="row text-right">
																{{ number_format($item_product->item_product_sell) }}
															</h6>
															@endif
														</div>

														<a
															href="{{ route('single_product', ['slug' => $item_product->item_product_slug]) }}">
															<div class="pi-text">
																<div class="row">
																	<div class="col-md-12">
																		<p>{{ $item_product->item_product_name }}
																		</p>
																	</div>
																</div>
															</div>
														</a>
														<div>
															<a class="btn btn-danger btn-sm"
																onclick="return confirm('Are you sure to delete product ?');"
																style="position: absolute;bottom:140px;right:15px;"
																href="{{ route('myaccount', ['delete' => $item_product->item_product_id]) }}">delete</a>
														</div>
													</div>
												</div>
												@endforeach

												<div
													class="text-xs-center text-center pagination pagination-centered w-100 pt-3">

													{{ $my_wishlist ? $my_wishlist->render("pagination::bootstrap-4") : '' }}

												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header" id="headingOne">
										<h2 class="mb-0">
											<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
												aria-expanded="true" aria-controls="collapseOne">
												Personal Data [ {{ Auth::user()->username ?? '' }} ]
											</button>
										</h2>
									</div>
								
									<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#">
										<div class="card-body">
											{!! Form::model($model, ['route' => 'myaccount', 'class' =>
											'form-horizontal', 'files' => true]) !!}
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Name : </label>
														{{ $model->name }}
														{!! $errors->first('name', '<p class=text-danger">:message</p>')
														!!}
													</div>
													<div class="form-group">
														<label>Email : </label>
														{{ $model->email }}
														{!! $errors->first('email', '<p class=text-danger">:message</p>
														') !!}
													</div>
													<div class="form-group">
														<label>Phone : </label>
														{{ $model->phone }}
														{!! $errors->first('phone', '<p class=text-danger">:message</p>
														') !!}
													</div>
												</div>
								
												<div class="col-md-3">
													<div class="form-group">
														<label>Province : </label>
														{{ $list_province[$model->province] ?? '' }}
													</div>
													<div class="form-group">
														<label>City : </label>
														{{ $list_city[$model->city] ?? '' }}
													</div>
													<div class="form-group">
														<label>Area : </label>
														{{ $list_location[$model->location] ?? '' }}
													</div>
								
								
												</div>
								
												<div class="col-md-6">
								
													<div class="form-group">
														<label>Address : </label>
														{!! $model->address !!} {{ $model->postcode }}
														{!! $errors->first('address', '<p class=text-danger">:message
														</p>
														') !!}
													</div>
								
												</div>
								
											</div>
											<div>
								
												<div class="pull-right">
													<a href="{{ route('userprofile') }}" class="btn btn-primary btn-sm">Update</a>
												</div>
								
												<br>
								
											</div>
											{!! Form::close() !!}
										</div>
								
								
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
</section>
@endsection

@push('javascript')
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() {
		$('#force-responsive').DataTable();
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

		$("#force-responsive").on('#track',function(){
		var userid = $(this).attr('data');
		alert(userid);
		return false;
			$.ajax({
				url: 'ajaxfile.php',
				type: 'post',
				data: {userid: userid},
				success: function(response){ 
				// Add response in Modal body
				$('.modal-body').html(response);

				// Display Modal
				$('#empModal').modal('show'); 
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

	});
</script>
@endpush

@push('css')

<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
	#force-responsive_wrapper {
		width: 100%;
	}

	#force-responsive_filter input {
		border: 0.5px solid #ced4da;
	}

	@media screen and (max-width: 520px) {
		table {
			width: 100% !important;
		}

		#force-responsive thead {
			display: none;
		}

		#force-responsive td {
			display: block;
			text-align: right;
			border-right: 1px solid #e1edff;
		}

		#force-responsive td::before {
			float: left;
			text-transform: uppercase;
			font-weight: bold;
			content: attr(data-header);
		}

		#force-responsive tr td:last-child {
			border-bottom: 2px solid #dddddd;
		}
	}
</style>
@endpush