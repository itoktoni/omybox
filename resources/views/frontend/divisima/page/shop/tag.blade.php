<div id="tag" class="filter-widget">
    <h2 class="fw-title">Tag</h2>
    <div class="fw-tag-choose">
        @foreach ($tag as $item_tag)
        <a class="btn btn-secondary btn-xs" href="{{ route('filters', ['type' => 'tag','slug' => $item_tag]) }}" role="button">{{ $item_tag }}</a>
        @endforeach
    </div>
</div>