<div class="filter-widget">
    <h2 class="fw-title">Categories</h2>
    <ul class="category-menu">
        @foreach ($public_category as $tag_category)
        <li>
            <a href="{{ route('filters', ['type' => 'category','slug' => $tag_category->item_category_slug ]) }}">{{ ucfirst($tag_category->item_category_name) }}</a>
        </li>
        @endforeach
    </ul>
</div>