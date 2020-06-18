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

            <div class="col-md-6 col-lg-6">
                {!!Form::open(['route' => 'cart', 'class' => 'form-cart', 'files' => true]) !!}
                @foreach (Cart::getContent() as $item_cart)
                <div class="col-md-12 col-lg-12">
                    <div class="menus cart-list d-sm-flex ftco-animate align-items-stretch">
                        
                        <div class="text d-flex align-items-center col-md-12">
                            <div class="width100">
                                <div class="d-flex">
                                    <div class="one-half">
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
                                    <div class="one-forth">
                                        <input id="qty" class="qty form-control text-center"
                                            name="cart[{{$loop->index}}][qty]" type="text"
                                            value="{{ old("cart[$loop->index][qty]") ?? $item_cart->quantity }}">
                                        <br>
                                        <span class="price" style="margin-top:-20px;">
                                            {{ number_format($item_cart->quantity * $item_cart->price) }}
                                        </span>
                                        <a onclick="return confirm('Are you sure to delete product ?');"
                                            class="btn btn-danger btn-xs pull-right"
                                            href="{{ route('delete', ['id' => $item_cart->id ]) }}">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="col-md-12 mb-2">
                    <div class="row">
                        <div class="col-md-12 text-right">

                            <table class="table table-striped">
                                <tr>
                                    <td class="text-right">
                                        Total Harga
                                    </td>
                                    <td>
                                        <span class="harga">
                                            {{ number_format(Cart::getTotal()) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="site-btn">Update</button>
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

                                {!!Form::open(['route' => 'confirmation', 'class' => 'checkout-form', 'files' => true])
                                !!}

                                <div class="row address-inputs">

                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                Nama Penerima
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <input
                                                    class="form-control {{ $errors->has('finance_payment_person') ? 'error' : ''}}"
                                                    name="finance_payment_person" type="text"
                                                    value="{{ old('finance_payment_person') ?? $order->sales_order_rajaongkir_name ?? '' }}"
                                                    placeholder="Nama Penerima">

                                                {!! $errors->first('finance_payment_person', '<p class="help-block">
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
                                                    class="form-control {{ $errors->has('finance_payment_person') ? 'error' : ''}}"
                                                    name="finance_payment_person" type="text"
                                                    value="{{ old('finance_payment_person') ?? $order->sales_order_rajaongkir_name ?? '' }}"
                                                    placeholder="Nama Email">

                                                {!! $errors->first('finance_payment_person', '<p class="help-block">
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
                                                    class="form-control {{ $errors->has('finance_payment_person') ? 'error' : ''}}"
                                                    name="finance_payment_person" type="text"
                                                    value="{{ old('finance_payment_person') ?? $order->sales_order_rajaongkir_name ?? '' }}"
                                                    placeholder="Nomor Hp">

                                                {!! $errors->first('finance_payment_person', '<p class="help-block">
                                                    :message
                                                </p>
                                                ') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                Notes
                                            </div>
                                            <div class="col-md-8 text-left">
                                                <textarea class="form-control" name="" id="" cols="24"
                                                    rows="5"></textarea>

                                                {!! $errors->first('finance_payment_person', '<p class="help-block">
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
                                                <button type="submit" name="submit" class="site-btn">Proceed</button>
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
@endif
{{-- <!-- cart section end -->
<section class="cart-section spad">
    <div class="container">
        <div class="col-md-5 pull-right">
            @if ($errors)
            @foreach ($errors->all() as $error)
            <div style="margin-top:-20px;" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $error }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endforeach
@endif
</div>
@if (Cart::getContent()->count() > 0)
<div class="row clearfix" style="clear: both;">
    {!!Form::open(['route' => 'cart', 'class' => 'header-search-form', 'files' => true]) !!}
    <div class="col-lg-12">
        <div class="cart-table">
            <div class="cart-table-warp">
                <table>
                    <thead>
                        <tr>
                            <th class="quy-th">
                                <h5>Image</h5>
                            </th>
                            <th class="product-th">
                                <h5 style="margin-left:20px;">Product</h5>
                            </th>
                            <th class="quy-th">
                                <h5>Qty</h5>
                            </th>
                            <th class="size-th">
                                <h5 class="text-right">Price</h5>
                            </th>
                            <th class="size-th">
                                <h5 class="text-right" style="margin-right:20px;">Total</h5>
                            </th>
                            <th class="total-th">
                                <h5 class="text-right">Action</h5>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!Cart::isEmpty())
                        @foreach (Cart::getContent() as $item_cart)
                        <tr id="render" class="{{ $errors->has("cart.$loop->index.qty") ? 'border-error' : '' }}">
                            <td class="total-col">
                                <img src="{{ Helper::files('product/thumbnail_'.$item_cart->attributes['image']) }}"
                                    alt="{{ $item_cart->name }}">
                            </td>
                            <td class="product-col" style="margin-right:20px;margin-left:20px;">
                                <div style="margin-top:50px;">
                                    <h4 class="text-left">
                                        <a class="text-secondary" style="font-size:15px;"
                                            href="{{ route('single_product', ['slug' => Str::slug($item_cart->name)]) }}">
                                            {{ $item_cart->name}}
                                        </a>
                                    </h4>
                                </div>
                            </td>
                            <td class="quy-col">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input id="qty" class="qty" name="cart[{{$loop->index}}][qty]" type="text"
                                            value="{{ old("cart[$loop->index][qty]") ?? $item_cart->quantity }}">

                                    </div>
                                </div>
                            </td>
                            <td class="size-col">
                                <h4 class="text-right">

                                    <p style="margin-top:0px;margin-bottom:0px;">
                                        {{ number_format($item_cart->price) }}</p>
                                    @if (config('website.tax') && !empty($item_cart->getConditions()))
                                    <p style="margin-bottom:0px;">
                                        +
                                        {{ number_format($item_cart->getConditions()->getValue() * $item_cart->quantity) }}
                                        {{ $item_cart->getConditions()->getName() }}
                                    </p>
                                    @endif
                                </h4>
                            </td>
                            <td class="size-col">
                                <div style="margin-right:20px;">
                                    <h4 class="text-right">
                                        {{ config('website.tax') && $item_cart->getConditions() ? number_format(($item_cart->quantity * $item_cart->price) + ($item_cart->getConditions()->getValue() * $item_cart->quantity)) : number_format($item_cart->quantity * $item_cart->price) }}
                                    </h4>
                                </div>
                            </td>

                            <td class="size-col">
                                <a onclick="return confirm('Are you sure to delete product ?');"
                                    class="btn btn-danger btn-xs pull-right"
                                    href="{{ route('delete', ['id' => $item_cart->id ]) }}">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        @if (Cart::getConditions()->count() > 0)
                        <tr>
                            <td class="total-col" colspan="5" style="border-top:1px solid #f51167;">
                                <h4 style="margin-top:20px;float:left;">
                                    Redem Discount :
                                    {{ Cart::getConditions()->first()->getAttributes()['name'] }}
                                </h4>
                                <h4 style="margin-top:20px;float:right">
                                    {{ number_format(Cart::getConditions()->first()->getValue()) }}
                                </h4>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="total-cost">
                <h6>Total <span>{{ number_format(Cart::getTotal()) }}</span></h6>
            </div>
        </div>
    </div>

    <div style="margin-top:20px;" class="col-lg-12 card-right">
        {!! Form::close() !!}

        <div class="row">
            <div class="col-md-4 col-sm-12 col-sx-12"></div>
            <div class="col-md-5 col-sm-12 col-sx-12 promo-code-form">
                {!! Form::open(['route' => 'cart', 'class' => 'promo-code-form', 'files' => true]) !!}
                <input type="text" name="code" value="{{ old('code') ?? null }}" placeholder="Enter promo code">
                <button type="submit">Submit</button>
                {!! Form::close() !!}
            </div>
            <div class="col-md-3 col-sm-12 col-sx-12">
                <a class="site-btn sb-dark pull-right" href="{{ route('checkout') }}">Checkout</a>
            </div>
        </div>

    </div>

</div>
</div>
@else
<div class="col-lg-12 card-right">
    <div class="row">
        <a href="{{ route('shop') }}" class="site-btn">Go to list catalog </a>
    </div>
</div>
@endif
</div>
</section> --}}

@endsection