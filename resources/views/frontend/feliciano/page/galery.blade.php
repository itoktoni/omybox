@extends(Helper::setExtendFrontend())

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script type="text/javascript" src="{{ Helper::frontend('js/jquery.poptrox.min.js') }}">
</script>
<script>
$(function() {
    $('.columns').poptrox({
        usePopupCaption: true
    });
});
</script>
@endpush

@section('content')
<section class="ftco-section">
    <div class="container">
        <div class="ftco-search">
            <div class="row">


                <!-- Main -->
                <div id="main">
                    <div class="inner">

                        <div class="nav-link-wrap">
                            <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">

                                @foreach($tag as $t)
                                <a class="nav-link ftco-animate fadeInUp ftco-animated {{ $loop->first ? 'show active' : '' }}"
                                    id="v-pills-1-tab" data-toggle="pill" href="#data{{ $t->item_tag_id }}" role="tab"
                                    aria-controls="data{{ $t->item_tag_id }}"
                                    aria-selected="true">{{ $t->item_tag_name }}</a>
                                @endforeach
                                <a class="nav-link ftco-animate fadeInUp ftco-animated"
                                    id="v-pills-1-tab" target="_blank" download href="{{ Helper::base_url().'/booklet.pdf' }}" >
                                BOOKLET    
                                </a>
                            </div>
                        </div>

                        <div class="col-md-12 tab-wrap">
                            <div class="tab-content" id="v-pills-tabContent">

                                @foreach($tag as $ta)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="data{{ $ta->item_tag_id }}" role="tabpanel" aria-labelledby="day-1-tab">

                                    <div class="row">
                                        <div id="galery" class="columns">
                                            @foreach($galery as $g)
                                            @php
                                            $da = array_flip(json_decode($g->marketing_galery_tag));
                                            @endphp
                                            @if(isset($da[strtolower($ta->item_tag_name)]))
                                            <div class="image fit">

                                                <a
                                                    href="{{ empty($g->marketing_galery_link) ? Helper::files('galery/'.$g->marketing_galery_image) : $g->marketing_galery_link }}">
                                                    <img title="{{ $g->marketing_galery_description }}"
                                                        src="{{ Helper::files('galery/'.$g->marketing_galery_image) }}"
                                                        alt="{{ $g->marketing_galery_description }}" />
                                                    @if(!empty($g->marketing_galery_link))
                                                    <span class="button-play oi ion-logo-youtube"></span>
                                                    @endif
                                                </a>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection