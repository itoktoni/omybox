@extends(Helper::setExtendFrontend())

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js">
</script>
@endpush

@section('content')
@if (Cart::getContent()->count() > 0)
<section class="ftco-section">
    <div class="container">
        <div class="row no-gutters justify-content-center mb-5 pb-2">
            <div class="col-md-12 text-center heading-section ftco-animate">
                <h2 class="mb-4">List Cart</h2>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="container">
            
                @if ($errors)
                @foreach ($errors->all() as $error)
                <div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $error }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </strong>
                </div>
                @endforeach
                @endif
            </div>

            <div class="col-md-6 col-lg-6">
                {!!Form::open(['route' => 'cart', 'class' => 'form-cart', 'files' => true]) !!}
                @foreach (Cart::getContent() as $item_cart)
                <div class="col-md-12 col-lg-12">
                    <div class="menus cart-list d-sm-flex ftco-animate align-items-stretch">

                        <div class="text d-flex align-items-center col-md-12">
                            <div class="width100">
                                <div class="row">
                                    <div class="col-md-7">
                                        <a data-lightbox="{{ $item_cart->attributes['image'] }}"
                                            data-title="{!! $item_cart->attributes['description'] !!}"
                                            href="{{ Helper::files('product/'.$item_cart->attributes['image']) }}">
                                            <h3>{{ $item_cart->name }}</h3>
                                        </a>
                                        {!! $item_cart->attributes['description'] !!}
                                        <span class="harga">
                                            Harga : {{ number_format($item_cart->price) }}
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="hidden" value="{{ $item_cart->id }}"
                                            name="cart[{{$loop->index}}][product]">
                                        <input id="qty" class="qty form-control col-md-6 offset-md-6 text-center"
                                            name="cart[{{$loop->index}}][qty]" type="text"
                                            value="{{ old("cart[$loop->index][qty]") ?? $item_cart->quantity }}">
                                        <h6 class="harga text-right">
                                            Total : {{ number_format($item_cart->quantity * $item_cart->price) }}
                                        </h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-1">
                                            <span class="col-md-5 mb-1">
                                                {{ $item_cart->attributes['brand_name'] }} -
                                                {{ $item_cart->attributes['brand_description'] }}
                                            </span>
                                            <span class="col-md-7">
                                                <textarea placeholder="Notes" name="cart[{{$loop->index}}][description]"
                                                    class="form-control">{{ old("cart[$loop->index][description]") ?? $item_cart->attributes['notes'] }}</textarea>
                                            </span>
                                        </div>

                                        <div class="row">
                                            <span class="col-md-9 mb-1">

                                            </span>
                                            <span class="col-md-3">
                                                <a onclick="return confirm('Are you sure to delete product ?');"
                                                    class="btn btn-danger col-md-12"
                                                    href="{{ route('delete', ['id' => $item_cart->id ]) }}">Delete</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-md-12 mb-2">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-sx-3 text-left">
                                    <span class="container">
                                        Voucher
                                    </span>
                                </div>
                                <div class="col-md-8 col-sm-12 col-sx-3 promo-code-form">
                                    {!! Form::open(['route' => 'cart', 'class' => 'promo-code-form', 'files' =>
                                    true]) !!}

                                    <div class="input-group">
                                        <input class="form-control" type="text" name="code"
                                            value="{{ old('code') ?? null }}" placeholder="Enter promo code">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-outline-secondary"
                                                type="button">Redeem</button>
                                        </div>
                                    </div>

                                    {!! Form::close() !!}
                                </div>

                            </div>

                            <hr>

                            <div class="row">
                                @if (Cart::getConditions()->count() > 0)
                                <div class="col-md-6">
                                    <div class="container">
                                        <span class="text-right">
                                            {{ Cart::getConditions()->first()->getAttributes()['name'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="container">
                                        <h6 class="harga text-right">
                                            Discount : {{ number_format(Cart::getConditions()->first()->getValue()) }}
                                        </h6>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if (Cart::getConditions()->count() > 0)
                            <hr style="margin-top:-15px;">
                            @endif

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="row">
                                        <h6 class="col-md-12 text-left">
                                            <button type="submit" name="submit" value="update"
                                                class="btn btn-info col-md-10">Update</button>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="container">
                                            <div class="col-md-12 text-sm-center text-lg-right btn btn-secondary">
                                                Total Harga : {{ number_format(Cart::getTotal()) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <div class="col-md-6 col-lg-6">
                <div class="row no-gutters justify-content-center mb-5 pb-2">
                    <div class="col-md-12 text-center heading-section ftco-animate">
                        <div class="menus cart-list d-sm-flex ftco-animate align-items-stretch">

                            <div id="billing" class="col-lg-12">

                                {!!Form::open(['route' => 'checkout', 'class' => 'checkout-form', 'files' => true]) !!}

                                <div class="row address-inputs">

                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                Nama Penerima
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <input
                                                    class="form-control {{ $errors->has('sales_order_rajaongkir_name') ? 'error' : ''}}"
                                                    name="sales_order_rajaongkir_name" type="text"
                                                    value="{{ old('sales_order_rajaongkir_name') ?? Auth::user()->name ?? '' }}"
                                                    placeholder="Nama Penerima">

                                                {!! $errors->first('sales_order_rajaongkir_name', '<p
                                                    class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                Nama Email
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <input
                                                    class="form-control {{ $errors->has('sales_order_email') ? 'error' : ''}}"
                                                    name="sales_order_email" type="text"
                                                    value="{{ old('sales_order_email') ?? Auth::user()->email ?? '' }}"
                                                    placeholder="Nama Email">

                                                {!! $errors->first('sales_order_email', '<p class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                No Handphone
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <input
                                                    class="form-control {{ $errors->has('sales_order_rajaongkir_phone') ? 'error' : ''}}"
                                                    name="sales_order_rajaongkir_phone" type="text"
                                                    value="{{ old('sales_order_rajaongkir_phone') ?? Auth::user()->phone ?? '62' }}"
                                                    placeholder="Nomor Hp">

                                                {!! $errors->first('sales_order_rajaongkir_phone', '<p
                                                    class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                Alamat Lengkap
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <textarea class="form-control" name="sales_order_rajaongkir_address"
                                                    rows="3">{{ old('sales_order_rajaongkir_address') ?? Auth::user()->address ?? '' }}</textarea>

                                                {!! $errors->first('sales_order_rajaongkir_address', '<p
                                                    class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                Catatan
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <textarea class="form-control" name="sales_order_rajaongkir_notes" id=""
                                                    rows="5">{{ old('sales_order_rajaongkir_notes') ?? '' }}</textarea>

                                                {!! $errors->first('sales_order_rajaongkir_notes', '<p
                                                    class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" name="submit"
                                                    class="btn btn-info">Proses</button>
                                            </div>
                                        </div>
                                    </div>
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
@else
<div class="jumbotron mt-5">
    <div class="container">
        @if(session()->has('success'))
        <div class="col-md-12 text-center">
            <div style="margin-top:-20px;" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Pemesanan Telah Success, Harap menunggu Konfirmasi Ongkir !</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif

        {!! config('website.header') !!}
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="{{ route('shop') }}" role="button">Buy Product</a>
        </p>
    </div>
</div>
@endif

@endsection