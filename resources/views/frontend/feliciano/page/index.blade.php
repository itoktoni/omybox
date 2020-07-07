@extends(Helper::setExtendFrontend())

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js">
</script>
@endpush

@section('content')
<section class="home-slider owl-carousel js-fullheight">
    @foreach ($sliders as $slider)

    <div class="slider-item js-fullheight"
        style="background-image: url(public/files/slider/{{ $slider->marketing_slider_image }});">
        <div class="container">
            <div class="row slider-text js-fullheight justify-content-center align-items-center"
                data-scrollax-parent="true">

                <div class="col-md-12 col-sm-12 text-center ftco-animate">
                    <span class="subheading">{{ $slider->marketing_slider_name }}</span>
                    <h1 class="mb-4">{{ $slider->marketing_slider_description }}</h1>
                </div>

            </div>
        </div>
    </div>
    @endforeach

</section>

<section style="height:100%;width:100%;background-color:transparent;position:absolute;bottom:0px"
    class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="featured d-none d-lg-block">
                    <div class="row block-black">
                        @foreach ($public_category->where('item_category_homepage', 1) as $item_category)
                        <div class="col-md-3 col-xs-3">
                            <a href="{{ route('shop').'#data'.$item_category->item_category_id }}">
                                <div class="featured-menus ftco-animate">
                                    <div class="menu-img img"
                                        style="background-image: url(public/files/category/{{ $item_category->item_category_image }});">
                                    </div>
                                    <div class="text text-center">
                                        <h3>{{ $item_category->item_category_name }}</h3>
                                        <p>
                                            {!! $item_category->item_category_description !!}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row no-gutters justify-content-center mb-5 pb-2">
            <div class="col-md-12 text-center heading-section ftco-animate">
                <span class="subheading">Specialties</span>
                <h2 class="mb-4">Our Menu</h2>
            </div>
        </div>
        <div class="row no-gutters d-flex align-items-stretch">
            @foreach ($data_product->chunk(4) as $item_products)
            @foreach ($item_products as $item_product)

            <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                <div class="menus d-sm-flex ftco-animate align-items-stretch">
                    <a href="{{ Helper::files('product/'.$item_product->item_product_image) }}"
                        data-lightbox="{{ $item_product->item_product_image }}"
                        data-title="{!! $item_product->item_product_description !!}"
                        class="menu-img img {{ intval($loop->iteration) % 3 == 0 || intval($loop->iteration) % 4 == 0 ? 'order-md-last' : '' }}"
                        style="background-image: url(public/files/product/{{ $item_product->item_product_image }});">
                    </a>

                    <div class="text d-flex align-items-center">
                        <div class="width100">
                            <a href="{{ Helper::files('product/'.$item_product->item_product_image) }}"
                                data-lightbox="{{ $item_product->item_product_image }}"
                                data-title="{!! $item_product->item_product_description !!}">

                                <div class="d-flex">
                                    <div class="one-half">
                                        <h3>{{ $item_product->item_product_name }}</h3>
                                    </div>
                                    <div class="one-forth">
                                        <span class="price">
                                            @if ($item_product->item_product_discount_type)
                                            <h6 class="coret">
                                                {{ number_format($item_product->item_product_sell) }}
                                            </h6>
                                            {{ number_format($item_product->item_product_discount_type == 1 ? $item_product->item_product_sell - ($item_product->item_product_discount_value * $item_product->item_product_sell) : $item_product->item_product_sell - $item_product->item_product_discount_value ) }}
                                            @else
                                            {{ number_format($item_product->item_product_sell) }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 d-lg-none">
                                        <div class="container">
                                            <img class="img-fluid"
                                                src="{{ Helper::files('product/'.$item_product->item_product_image) }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="container mt-2">
                                            {!! $item_product->item_product_description !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="container">
                                        <h6 class="text-right">
                                            <a href="{{ route('add', ['id' => $item_product->item_product_id ]) }}"
                                                class="btn btn-primary add-cart text-right">Order
                                                now</a>
                                        </h6>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-left">
                                            {{ $item_product->brand->item_brand_name ?? '' }} -
                                            {{ $item_product->brand->item_brand_description ?? '' }}
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
            @endforeach

        </div>
    </div>
</section>

<section id="form" class="ftco-section img" style="background-image: url(public/frontend/feliciano/images/bg_3.jpg)"
    data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-12 makereservation p-4 px-md-5 pb-md-5">
                <div class="heading-section mb-5 text-center">
                    <h2 class="mb-4">Make Confirmation</h2>
                </div>
                {!!Form::open(['route' => 'confirmation', 'class' => 'contact-form', 'files' => true]) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Order</label>
                            <input
                                class="form-control {{ $errors->has('finance_payment_sales_order_id') ? 'error' : ''}}"
                                name="finance_payment_sales_order_id" type="text"
                                value="{{ old('finance_payment_sales_order_id') ?? $order->sales_order_id ?? '' }}"
                                placeholder="Order Number">
                            {!! $errors->first('finance_payment_sales_order_id', '<p class="help-block text-danger">
                                :message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Tanggal Pembayaran</label>
                            <input class="form-control {{ $errors->has('finance_payment_date') ? 'error' : ''}}"
                                id="book_date" name="finance_payment_date" type="text"
                                value="{{ old('finance_payment_date') ?? date('Y-m-d') }}" placeholder="Payment Date">
                            {!! $errors->first('finance_payment_date', '<p class="help-block text-danger">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nama Pengirim</label>
                            <input type="text"
                                class="form-control {{ $errors->has('finance_payment_person') ? 'error' : ''}}"
                                name="finance_payment_person" value="{{ old('finance_payment_person') ?? '' }}"
                                placeholder="Nama Pengirim">
                            {!! $errors->first('finance_payment_person', '<p class="help-block text-danger">:message</p>
                            ') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Bank Penerima</label>
                            <div id="select" class="{{ $errors->has('finance_payment_to') ? 'error' : ''}}"">
                                {{ Form::select('finance_payment_to', $bank, null, ['class'=> 'form-control']) }}
                            </div>
                            {!! $errors->first('finance_payment_to', '<p class=" help-block text-danger">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('finance_payment_email') ? 'error' : ''}}"
                                    name="finance_payment_email"
                                    value="{{ old('finance_payment_email') ?? $order->sales_order_email ?? '' }}"
                                    placeholder="Email">
                                {!! $errors->first('finance_payment_email', '<p class="help-block text-danger">:message
                                </p>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="text"
                                    class="form-control money {{ $errors->has('finance_payment_amount') ? 'error' : ''}}"
                                    name="finance_payment_amount"
                                    value="{{ old('finance_payment_amount') ?? $order->sales_order_total ?? '' }}"
                                    placeholder="Payment Amount">
                                {!! $errors->first('finance_payment_amount', '<p class="help-block text-danger">:message
                                </p>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Notes</label>
                                <textarea name="finance_payment_note" class="form-control" id="" cols="30"
                                    rows="3">{{ old('finance_payment_note') ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Files</label>
                                <input type="file" name="files"
                                    class="form-control {{ $errors->has('files') ? 'error' : ''}} btn btn-default btn-sm btn-block">
                                {!! $errors->first('files', '<p class="help-block text-danger">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <div class="col-md-7 text-center">
                                    @if(session()->has('success'))
                                    <div style="margin-top:-20px;"
                                        class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Konfirmasi Pemesanan Success !</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if ($errors->any())
                            @foreach ($errors->all() as $error)
                            @if ($loop->first)
                            <p class="help-block text-danger text-sm-left text-left">
                                * <strong>{{ $error }}</strong><br>
                            </p>
                            @endif
                            @endforeach
                            @endif
                            <div class="form-group text-right">
                                <input type="submit" value="Konfirmasi Pembayaran" class="btn btn-primary py-3 px-5">
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
</section>
@endsection