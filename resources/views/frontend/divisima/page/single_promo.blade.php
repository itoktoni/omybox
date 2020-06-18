@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h2>{{ $data->marketing_promo_name }}</h2>
		<br>
		<h4>Code Promo : <code>{{ $data->marketing_promo_code }}</code></h4>
		<br>
		@if ($data->marketing_promo_start_date && $data->marketing_promo_start_date != '0000-00-00 00:00:00')
		<div class="pull-right">
			Effective Date : {{ $data->marketing_promo_start_date }} - {{ $data->marketing_promo_end_date }}
		</div>
		@endif
	</div>
</div>
<!-- Page info end -->

<!-- product section -->
<section class="product-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 product-details">
				<div class="panel">
					<div aria-labelledby="headingOne" data-parent="#accordion">
						<div class="panel-body">
							<img class="col-md-6 img-thumnail float-left" src="{{ $data->marketing_promo_image }}"
								alt="">
							{!! html_entity_decode($data->marketing_promo_page) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- product section end -->
@endsection