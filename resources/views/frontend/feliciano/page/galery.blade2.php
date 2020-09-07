@extends(Helper::setExtendFrontend())

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
<script type="text/javascript" src="{{ Helper::frontend('js/jquery.poptrox.min.js') }}">
</script>
<script>
$(function() {
    $('#galery').poptrox({
        usePopupCaption: true
    });
});
</script>
@endpush

@push('css')
<style>
/* Image */

.image {
    border-radius: 4px;
    border: 0;
    display: inline-block;
    position: relative;
}

.image img {
    border-radius: 4px;
    display: block;
}

.image.left,
.image.right {
    max-width: 40%;
}

.image.left img,
.image.right img {
    width: 100%;
}

.image.left {
    float: left;
    margin: 0 1.5em 1em 0;
    top: 0.25em;
}

.image.right {
    float: right;
    margin: 0 0 1em 1.5em;
    top: 0.25em;
}

.image.fit {
    display: block;
    margin: 0 0 2em 0;
    width: 100%;
}

.image.fit img {
    width: 100%;
}

.image.main {
    display: block;
    margin: 0 0 3em 0;
    width: 100%;
}

.image.main img {
    width: 100%;
}

/* Columns */

.columns {
    position: relative;
    -moz-column-count: 4;
    -webkit-column-count: 4;
    column-count: 4;
    -moz-column-gap: 1em;
    -webkit-column-gap: 1em;
    column-gap: 1em;
}

.columns .image {
    position: relative;
    display: inline-block;
    margin: 0 0 .5em;
    width: 100%;
    overflow: hidden;
}

.columns .image img {
    -moz-transition: -moz-transform 0.2s ease-in-out;
    -webkit-transition: -webkit-transform 0.2s ease-in-out;
    -ms-transition: -ms-transform 0.2s ease-in-out;
    transition: transform 0.2s ease-in-out;
    -webkit-backface-visibility: hidden;
    -webkit-transform: translate3D(0, 0, 0);
}

.columns .image:hover img {
    -moz-transform: scale(1.1);
    -webkit-transform: scale(1.1);
    -ms-transform: scale(1.1);
    transform: scale(1.1);
}

@media screen and (max-width: 736px) {

    .columns {
        -moz-column-count: 2;
        -webkit-column-count: 2;
        column-count: 2;
    }

}

@media screen and (max-width: 480px) {

    .columns {
        -moz-column-count: 1;
        -webkit-column-count: 1;
        column-count: 1;
    }

}

.button-play {
    position: absolute;
    top: 40%;
    left: 40%;
    font-size: 60px;
    z-index: 999;
    color: red;
    background-color: RGBA(255, 255, 255, 0.4);
    padding: 0px 10px 5px 10px;
    border-radius: 20px;
}
</style>
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
                                <a class="nav-link ftco-animate fadeInUp ftco-animated {{ $loop->first ? 'show active' : '' }}" id="v-pills-1-tab"
                                    data-toggle="pill" href="#{{ $t->item_tag_id }}" role="tab" aria-controls="data{{ $t->item_tag_id }}"
                                    aria-selected="true">{{ $t->item_tag_name }}</a>
                                    @endforeach
                                    
                                </div>
                            </div>
                            
                            <div class="col-md-12 tab-wrap">
                                <div class="tab-content" id="v-pills-tabContent">
                                    
                                @foreach($tag as $ta)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="data{{ $ta->item_tag_id }}" role="tabpanel"
                                    aria-labelledby="day-1-tab">
                                    {{ $ta->item_tag_id }}
                                    <div class="row">
                                        <div id="galery" class="columns">
                                            <!-- Column 1 (horizontal, vertical, horizontal, vertical) -->
                                            <div class="image fit">
                                                <a href="images/pic01.jpg"><img title="A Brightcove Video"
                                                        src="images/pic01.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="href=http://youtu.be/loGm3vT8EAQ">
                                                    <span class="button-play oi ion-logo-youtube"></span>
                                                    <img src="images/pic02.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic03.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic04.jpg" alt="" /></a>
                                            </div>

                                            <!-- Column 2 (vertical, horizontal, vertical, horizontal) -->
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic06.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic05.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic08.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic07.jpg" alt="" /></a>
                                            </div>

                                            <!-- Column 3 (horizontal, vertical, horizontal, vertical) -->
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic09.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic12.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic11.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic10.jpg" alt="" /></a>
                                            </div>

                                            <!-- Column 4 (vertical, horizontal, vertical, horizontal) -->
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic13.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic14.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic15.jpg" alt="" /></a>
                                            </div>
                                            <div class="image fit">
                                                <a href="detail1.html"><img src="images/pic16.jpg" alt="" /></a>
                                            </div>

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