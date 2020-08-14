<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-center">
                <h6>
                    {{ config('website.footer') }}
                </h6>
            </div>
            <div class="col-md-4">
                <ul class="col-md-12 ftco-footer-social text-center">
                    @foreach ($public_sosmed as $sosmed)
                    <li class="ftco-animate"><a target="_blank" href="{{ $sosmed->marketing_sosmed_link }}"><span
                                class="icon-{{ $sosmed->marketing_sosmed_icon }}"></span></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>