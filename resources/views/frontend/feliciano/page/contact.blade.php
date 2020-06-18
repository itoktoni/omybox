@extends(Helper::setExtendFrontend())

@section('content')

<section class="ftco-section mt-5 ftco-no-pt ftco-no-pb contact-section">
    <div class="container">
        <div class="row d-flex align-items-stretch no-gutters">
            <div class="col-md-6 pt-5 px-2 pb-2 p-md-5 order-md-last">
                <h2 class="h4 mb-2 mb-md-5 font-weight-bold">Contact Us</h2>
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                @if ($loop->first)
                <span class="help-block text-danger text-sm-left text-left">
                    <strong>{{ $error }}</strong><br>
                </span>
                @endif
                @endforeach
                @endif
                {!!Form::open(['route' => 'contact', 'class' => 'contact-form']) !!}
                <div class="form-group">
                    <input type="text" name="marketing_contact_name" class="form-control" placeholder="Your Name">
                </div>
                <div class="form-group">
                    <input type="text" name="marketing_contact_email" class="form-control" placeholder="Your Email">
                </div>

                <div class="form-group">
                    <input type="text" name="marketing_contact_phone" class="form-control" placeholder=" Your Phone">
                </div>
                <div class="form-group">
                    <textarea name="marketing_contact_message" id="" cols="30" rows="3" class="form-control" placeholder="Message"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-6 pt-5 d-flex align-items-stretch">
                {!! config('website.maps') !!}
            </div>
        </div>
    </div>
</section>

@endsection