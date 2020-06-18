@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Category Product</h4>
		<div class="site-pagination">
			<a href="">Home</a> /
			<a href="">Category</a> /
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- Category section -->
<section id="category" class="category-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12  order-1 order-lg-2 mb-5 mb-lg-0">
				<div class="row">
					@isset($public_category)
					@foreach ($public_category as $item_category)
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<a href="{{ route('filters', ['type' => 'category', 'slug' => $item_category->item_category_slug]) }}">
								<div class="pi-pic">
									@if($item_category->item_category_flag)
									<div class="tag-sale">{{ $item_category->item_category_flag }}</div>
									@endif
									<img src="{{ Helper::files('category/'.$item_category->item_category_image) }}" alt="{{ $item_category->item_category_name }}">
								</div>
								<div class="pi-text">
									<p class="text-center">{{ $item_category->item_category_name }}</p>
								</div>
							</a>
						</div>
					</div>
					@endforeach
					@endisset
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Category section end -->
@endsection