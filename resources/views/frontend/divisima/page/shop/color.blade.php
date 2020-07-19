<div id="tag" class="filter-widget">
    <h2 class="fw-title">Color</h2>
    <div class="fw-tag-choose">
        @foreach ($color as $item_color)
        <a style="border:2px solid #{{ $item_color->item_color_code }};" class="btn btn-light btn-xs"
            href="{{ route('filters', ['type' => 'color','slug' => $item_color->item_color_slug ]) }}"
            role="button">{{ $item_color->item_color_slug }}</a>
        @endforeach
    </div>
</div>