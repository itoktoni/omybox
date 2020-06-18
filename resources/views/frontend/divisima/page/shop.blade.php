@extends(Helper::setExtendFrontend())

@section('content')

<div id="">
	<div class="page-top-info">
		<div class="container">
			<h4>Catalog Product</h4>
			<div class="site-pagination">
				<a href="{{ Helper::base_url() }}">Home</a> /
				<a href="{{ route('shop') }}">Shop</a>
			</div>
		</div>
	</div>

	<section class="category-section spad">
		<div class="container">

			<div class="row">
				<div class="col-lg-3 order-2 order-lg-1">
					@include(Helper::setExtendFrontend('shop.category', true))
					@include(Helper::setExtendFrontend('shop.brand', true))
					@include(Helper::setExtendFrontend('shop.tag', true))
				</div>

				<div class="col-lg-9  order-1 order-lg-2 mb-5 mb-lg-0">
					@if (session()->has('filter') && count(session()->get('filter')) > 0)
					<div class="row">
						<div class="col-lg-12">
							<button type="button" class="btn btn-danger btn-xs">
								Filter :
							</button>
							@foreach (session()->get('filter') as $key_filter => $value_filter)
							@if ($key_filter == 'item_product_name')
							<a onclick="return confirm('Are you sure to delete filter ?');"
								href="{{ route('filters', ['type' => 'remove_filter', 'slug' => $key_filter]) }}"
								class="btn btn-secondary btn-xs">
								{{ $value_filter }} <span class="badge badge-light">x</span>
							</a>
							@else
							@foreach ($value_filter as $filter_filter)
							<a onclick="return confirm('Are you sure to delete filter ?');"
								href="{{ route('filters', ['type' => 'remove_filter', 'slug' => $key_filter.'.'.$filter_filter]) }}"
								class="btn btn-secondary btn-xs">
								{{ $filter_filter }} <span class="badge badge-light">x</span>
							</a>
							@endforeach
							@endif
							@endforeach

							<a onclick="return confirm('Are you sure to reset filter ?');"
								href="{{ route('filters', ['type' => 'reset', 'slug' => true]) }}"
								class="btn btn-danger btn-xs">
								Reset
							</a>

						</div>
					</div>
					@endif
					<br>
					@include(Helper::setExtendFrontend('shop.product', true))
				</div>
			</div>
		</div>
	</section>

</div>
@endsection

@push('javascript')
@if(config('website.env') == 'local')
<script src="{{ Helper::backend('vendor/pjax/pjax.min.js') }}"></script>
@else
<script src="https://cdn.jsdelivr.net/npm/pjax@0.2.8/pjax.min.js"></script>
@endif

<script>
	document.addEventListener("pjax:error", function(e) {
    console.log(e);
    window.location.replace(e.request.responseURL);
});

document.addEventListener("pjax:success", function(e) {
		console.log(e);
	});

document.addEventListener("DOMContentLoaded", function() {
    pjax = new Pjax({
        elements: ["a"],
        selectors: ["#pjax, #count"],
        cacheBust: false
    });
});

$(document).on('click', '.add-card', function() {
	var product = $(this).attr('alt');
    $.notiny({ text: 'ADD '+product, position: 'right-top' });
});

</script>

@endpush