@extends(Helper::setExtendFrontend())

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js">
</script>
@endpush

@section('content')
<section class="ftco-section">
    <div class="container">
        <div class="ftco-search">
            <div class="row">
                <div class="col-md-12 nav-link-wrap">

                    <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        @foreach ($public_category as $tag_category)

                        <a class="nav-link ftco-animate {{ $loop->first ? 'active' : '' }}" id="v-pills-1-tab"
                            data-toggle="pill" href="#data{{ $tag_category->item_category_id }}" role="tab"
                            aria-controls="data{{ $tag_category->item_category_id }}"
                            aria-selected="true">{{ $tag_category->item_category_name }}</a>

                        @endforeach

                    </div>
                </div>
                <div class="col-md-12 tab-wrap">

                    <div class="tab-content" id="v-pills-tabContent">

                        @foreach ($category as $category_data)

                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                            id="data{{ $category_data->item_category_id }}" role="tabpanel" aria-labelledby="day-1-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                @foreach ($category_data->product->chunk(4) as $item)
                                @foreach ($item as $item_product)

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <a href="{{ Helper::files('product/'.$item_product->item_product_image) }}"
                                            data-lightbox="{{ $item_product->item_product_image }}"
                                            data-title="{!! $item_product->item_product_description !!}"
                                            class="menu-img img {{ intval($loop->iteration) % 3 == 0 || intval($loop->iteration) % 4 == 0 ? 'order-md-last' : '' }}"
                                            style="background-image: url(public/files/product/{{ $item_product->item_product_image }});">
                                        </a>
                                        @if(!empty($item_product->item_product_flag))
                                        <span class="flag">
                                            {{ $item_product->item_product_flag }}
                                        </span>
                                        @endif

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
                                                                <p>
                                                                    {!! $item_product->item_product_description !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="container">
                                                            <h6 class="text-right">
                                                                @if($item_product->item_product_status == 1)
                                                                <a href="{{ route('add', ['id' => $item_product->item_product_id ]) }}"
                                                                    class="btn btn-primary add-cart text-right">Order
                                                                    now</a>
                                                                @else
                                                                <a href="#"
                                                                    class="btn btn-primary add-cart text-right">Sold Out</a>
                                                                @endif
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

                        @endforeach

                        {{-- <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/lunch-1.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/lunch-2.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/lunch-3.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/lunch-4.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/lunch-5.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/lunch-6.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/lunch-7.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/lunch-8.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/dinner-1.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/dinner-2.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/dinner-3.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/dinner-4.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/dinner-5.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/dinner-6.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-day-4-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/drink-1.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/drink-2.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/drink-3.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/drink-4.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/drink-5.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/drink-6.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-day-5-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/dessert-1.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/dessert-2.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/dessert-3.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/dessert-4.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/dessert-5.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/drink-6.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-day-6-tab">
                            <div class="row no-gutters d-flex align-items-stretch">
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/wine-1.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/wine-2.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/wine-3.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/wine-4.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/wine-5.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img"
                                            style="background-image: url(public/frontend/feliciano/images/wine-6.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/wine-7.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 d-flex align-self-stretch">
                                    <div class="menus d-sm-flex ftco-animate align-items-stretch">
                                        <div class="menu-img img order-md-last"
                                            style="background-image: url(public/frontend/feliciano/images/wine-8.jpg);">
                                        </div>
                                        <div class="text d-flex align-items-center">
                                            <div>
                                                <div class="d-flex">
                                                    <div class="one-half">
                                                        <h3>Grilled Beef with potatoes</h3>
                                                    </div>
                                                    <div class="one-forth">
                                                        <span class="price">$29</span>
                                                    </div>
                                                </div>
                                                <p><span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
                                                    <span>Tomatoe</span></p>
                                                <p><a href="#" class="btn btn-primary">Order now</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection