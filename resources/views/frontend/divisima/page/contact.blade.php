@extends(Helper::setExtendFrontend())

@section('content')

<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Contact</h4>
		<div class="site-pagination">
			<a href="{{ Helper::base_url() }}">Home</a> /
			<a href="{{ route('contact') }}">Contact</a>
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- Contact section -->
<section class="contact-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 contact-info">
				<h3>Get in touch</h3>
				<p>{!! config('website.address') !!}</p>
				<p>{{ config('website.phone') }}</p>
				<p>{{ config('website.email') }}</p>

				{!!Form::open(['route' => 'contact', 'class' => 'contact-form']) !!}
				<input type="text" class="{{ $errors->has('marketing_contact_name') ? 'error' : ''}}" value="{{ old('marketing_contact_name') ?? null }}" name="marketing_contact_name" placeholder="Your name">
				<input type="text" class="{{ $errors->has('marketing_contact_email') ? 'error' : ''}}" value="{{ old('marketing_contact_email') ?? null }}" name="marketing_contact_email" placeholder="Your e-mail">
				<input type="text" class="{{ $errors->has('marketing_contact_phone') ? 'error' : ''}}" value="{{ old('marketing_contact_phone') ?? null }}" name="marketing_contact_phone" placeholder="Phone">
				<input type="text" class="{{ $errors->has('marketing_contact_subject') ? 'error' : ''}}" value="{{ old('marketing_contact_subject') ?? null }}" name="marketing_contact_subject" placeholder="Subject">
				<textarea class="{{ $errors->has('marketing_contact_message') ? 'error' : ''}}" name="marketing_contact_message" placeholder="Message">{{ old('marketing_contact_message') ?? null }}</textarea>
				<button type="submit" class="site-btn">SEND NOW</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="map">
		{!! config('website.maps') !!}
	</div>
</section>
<!-- Contact section end -->

<!-- Related product section end -->
@endsection