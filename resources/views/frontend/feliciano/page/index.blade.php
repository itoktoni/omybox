@extends(Helper::setExtendFrontend())

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

            @foreach ($data_product->chunk(4) as $item_product)
            @foreach ($item_product as $itemp)
           
            <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                <div class="menus d-sm-flex ftco-animate align-items-stretch">
                    <a href="{{ Helper::files('product/'.$itemp->item_product_image) }}"
                        data-lightbox="{{ $itemp->item_product_image }}"
                        data-title="{!! $itemp->item_product_description !!}"
                        class="menu-img img {{ $loop->iteration > 1 ? 'order-md-last' : '' }}"
                        style="background-image: url(public/files/product/{{ $itemp->item_product_image }});">
                    </a>
            
                    <div class="text d-flex align-items-center">
                        <div class="width100">
                            <div class="d-flex">
                                <div class="one-half">
                                    <h3>{{ $itemp->item_product_name }}</h3>
                                </div>
                                <div class="one-forth">
                                    <span class="price">
                                        @if ($itemp->item_product_discount_type)
                                        <h6 class="coret">{{ number_format($itemp->item_product_sell) }}</h6>
                                        {{ number_format($itemp->item_product_discount_type == 1 ? $itemp->item_product_sell - ($itemp->item_product_discount_value * $itemp->item_product_sell) : $itemp->item_product_sell - $itemp->item_product_discount_value ) }}
                                        @else
                                        {{ number_format($itemp->item_product_sell) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            {!! $itemp->item_product_description !!}
            
                            <a href="{{ route('add', ['id' => $itemp->item_product_id ]) }}"
                                class="btn btn-primary add-cart">Order now</a>
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
                    <h2 class="mb-4">Make Reservation</h2>
                </div>
                {!!Form::open(['route' => 'contact', 'class' => 'contact-form']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="marketing_contact_name" class="form-control"
                                placeholder="Your Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="marketing_contact_email" class="form-control"
                                placeholder="Your Email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" name="marketing_contact_phone" class="form-control" placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" name="marketing_contact_date" class="form-control" id="book_date"
                                placeholder="Date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="marketing_contact_address" class="form-control" id="" cols="30"
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Order</label>
                            <textarea name="marketing_contact_name" class="form-control" id="" cols="30"
                                rows="3"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        @if ($loop->first)
                        <span class="help-block text-danger text-sm-left text-left">
                            <strong>{{ $error }}</strong><br>
                        </span>
                        @endif
                        @endforeach
                        @endif
                        <div class="form-group text-right">
                            <input type="submit" value="Make a Reservation" class="btn btn-primary py-3 px-5">
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection