<div class="filter-widget mb-0">
    <h2 class="fw-title">Brand</h2>
    <ul class="category-menu">
        @foreach ($brand as $key => $item_brand)
        <li><a href="{{ route('filters', ['type' => 'brand','slug' => $item_brand]) }}">{{ $key }}</a></li>
        @endforeach
    </ul>
</div>