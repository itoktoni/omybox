<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-center">

                <div>
                    {!! config('website.address') !!}
                </div>

            </div>
            <div class="col-md-4">
                <ul class="col-md-12 ftco-footer-social text-center">
                    @foreach ($public_sosmed as $sosmed)
                    <li class="ftco-animate"><a target="_blank" href="{{ $sosmed->marketing_sosmed_link }}"><span
                                class="icon-{{ $sosmed->marketing_sosmed_icon }}"></span></a></li>
                    @endforeach
                </ul>

                <p style="margin-top:-20px" class="text-center">
                    Design by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                </p>

            </div>
        </div>
    </div>
</footer>