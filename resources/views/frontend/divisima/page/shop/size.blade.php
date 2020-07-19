<div id="tag" class="filter-widget mb-0">
    <h2 class="fw-title">Size</h2>
    <div class="fw-size-choose">

        @foreach ($size as $item_size)
        <a href="{{ route('filters', ['type' => 'size','slug' => $item_size]) }}" class="btn btn-light" active
            style="box-shadow: 1px 2px 2px rgba(0, 0, 0, 0.2);">{{ $item_size }}
        </a>
        @endforeach

    </div>
</div>