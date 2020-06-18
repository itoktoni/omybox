@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<a href="{{ $data->marketing_slider_link }}">
			<h2>{{ $data->marketing_slider_name }}</h2>
		</a>
		<br>
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
							<img class="col-md-6 img-thumnail float-left"
								src="{{ Helper::files('slider/'.$data->marketing_slider_image) }}" alt="">
							{!! html_entity_decode($data->marketing_slider_page) !!}
						</div>
						<div class="panel-footer">
							<a class="btn btn-danger pull-right" href="{{ $data->marketing_slider_link }}">{{ $data->marketing_slider_button }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- product section end -->
@endsection