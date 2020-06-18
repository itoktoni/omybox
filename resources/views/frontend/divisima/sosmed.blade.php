<div class="social-links text-center">
    @foreach ($public_sosmed as $item_sosmed)
    <a target="_blank" href="{{ $item_sosmed->marketing_sosmed_link }}"><i class="fa fa-{{ $item_sosmed->marketing_sosmed_icon }}"></i><span>{{ $item_sosmed->marketing_sosmed_name }}</span></a>
    @endforeach
</div>