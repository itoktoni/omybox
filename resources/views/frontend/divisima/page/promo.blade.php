@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Promo Product</h4>
		<div class="site-pagination">
			<a href="">Home</a> /
			<a href="">Promo</a> /
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- Category section -->
<section class="category-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12  order-1 order-lg-2 mb-5 mb-lg-0">
				<div class="row">

					<div class="col-lg-6 col-sm-6">
						<div class="product-item">
							<a href="{{ route('single_promo', ['slug' => $single->marketing_promo_slug]) }}">
								<div class="header">
									<h2 class="text-center">
										{{ $single->marketing_promo_name }}
									</h2>
								</div>
								<div class="col-md-12">
									<div class="">
										<img class=" mx-auto d-block img-thumbnail" src="{{ Helper::files('promo/'.$single->marketing_promo_image) }}" alt="">
									</div>
								</div>
								<div class="pi-text">
									<p class="text-center">{{ $single->marketing_promo_description }}</p>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6">
						<div class="row">
							@foreach ($promo as $item_promo)
							<div
								class="col-lg-6 col-sm-6																																																																																																																																																																																																																																																																																																																																																																																																									">
								<div class="product-item">
									<a
										href="{{ route('single_promo', ['slug' => $item_promo->marketing_promo_slug]) }}">
										<div class="img-thumbnail">
											<img src="{{ Helper::files('promo/'.$item_promo->marketing_promo_image) }}"
												alt="">
										</div>
										<div class="pi-text">
											<p class="text-center">{{ $item_promo->marketing_promo_name }}</p>
										</div>
									</a>
								</div>
							</div>
							@endforeach

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Category section end -->
@endsection