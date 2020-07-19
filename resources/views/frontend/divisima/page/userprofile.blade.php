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
					<div class="card">

						<div class="card-header" id="headingOne">
							<h2 class="mb-0">
								<button class="btn btn-link" type="button">
									Personal Data [ {{ Auth::user()->username ?? '' }} ]
								</button>
							</h2>

						</div>

						<div class="card-body" style="border-bottom:1px solid lightgrey;background-color:white">
							{!! Form::model($model, ['route' => 'userprofile', 'class' =>
							'form-horizontal', 'files' => true]) !!}
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Name</label>
										{!! Form::text('name', null, ['class' => 'form-control']) !!}
										{!! $errors->first('name', '<p class=text-danger">:message</p>')
										!!}
									</div>
									<div class="form-group">
										<label>Email</label>
										{!! Form::email('email', null, ['class' => 'form-control']) !!}
										{!! $errors->first('email', '<p class=text-danger">:message</p>
										') !!}
									</div>
									<div class="form-group">
										<label>Phone</label>
										{!! Form::text('phone', null, ['class' => 'form-control']) !!}
										{!! $errors->first('phone', '<p class=text-danger">:message</p>
										') !!}
									</div>
								</div>

								<div class="col-md-4">

									<div class="form-group">
										<label>Password</label>
										{!! Form::password('password', ['class' => 'form-control']) !!}
										{!! $errors->first('password', '<p class=text-danger">:message
										</p>
										') !!}
									</div>

									<div class="form-group">
										<label>Address</label>
										{!! Form::textarea('address', null, ['class' => 'form-control',
										'rows' => '3']) !!}
										{!! $errors->first('address', '<p class=text-danger">:message
										</p>
										') !!}
									</div>

									<div class="form-group row">
										<div class="col-md-3">
											<label>Postcode</label>
										</div>
										<div class="col-md-9">
											{!! Form::text('postcode', null, ['class' =>
											'form-control'])
											!!}
											{!! $errors->first('postcode', '<p class=text-danger">
												:message
											</p>
											') !!}
										</div>
									</div>

								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Province</label>
										{{ Form::select('province', $list_province, $province, ['id' => 'province', 'class'=> 'form-control chosen '.($errors->has('province') ? 'error':'')]) }}
									</div>
									<div class="form-group">
										<label>City</label>
										{{ Form::select('city', $list_city, $city, ['id' => 'city','class'=> 'form-control chosen']) }}
									</div>
									<div class="form-group">
										<label>Area</label>
										{{ Form::select('location', $list_location, $location, ['id' => 'location','class'=> 'form-control chosen '.($errors->has('location') ? 'error':'')]) }}
									</div>
									<div class="pull-right">
										<button type="submit" class="btn btn-primary btn-sm">Save
											Data</button>
									</div>

								</div>
								{!! Form::close() !!}
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

	.card-body {
		position: relative;
		z-index: 999999999;
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