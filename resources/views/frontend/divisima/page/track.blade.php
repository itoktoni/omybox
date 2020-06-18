@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h2>
			Waybill : {{ $waybill->summary->waybill_number }}
		</h2>
		<div class="site-pagination">
			<a href="{{ Helper::base_url() }}">Home</a> |
			<a href="{{ route('myaccount') }}">My Account</a> |
			<a href="#">{{ $waybill->summary->courier_name }}</a> :
			<a href="#">{{ $waybill->summary->service_code }}</a>
		</div>
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
							<ul class="list-group">
								<li
									class="list-group-item d-flex justify-content-between align-items-center list-group-item-primary">
									<span class="col-md-10">
										From : {{ $waybill->details->shippper_name }}
									</span>
									<span class="btn btn-info btn-sm col-md-2">{{ $waybill->details->waybill_date }}
										{{ $waybill->details->waybill_time }}</span>
								</li>
								@if ($waybill->manifest)
								@foreach ($waybill->manifest as $status)
								<li class="list-group-item d-flex justify-content-between align-items-center">
									<span class="col-md-10">
										{{ str_replace('~~', '',$status->manifest_description) }}
									</span>
									<span class="btn btn-info btn-sm col-md-2">{{ $status->manifest_date }}
										{{ $status->manifest_time }}</span>
								</li>
								@endforeach
								@endif
								@if ($summary = $waybill->summary)
								<li
									class="list-group-item d-flex justify-content-between align-items-center list-group-item-success">
									<span class="col-md-10">
										Status : {{ $summary->status }} to {{ $summary->receiver_name ?? '' }}
									</span>
									<span class="btn btn-secondary btn-sm col-md-2">{{ $summary->waybill_date }}</span>
								</li>
								@endif

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
<!-- product section end -->
@endsection