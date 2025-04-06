<div class="sidebar">
    <!-- Search Section -->
    <div class="sidebar__single sidebar__search">
        <form action="{{ route('blog.index') }}" method="GET" class="sidebar__search-form">
            <input type="search" name="search" placeholder="Keyword..." value="{{ request()->get('search') }}">
            <button type="submit"><i class="icon-magnifying-glass"></i></button>
        </form>
    </div>

    <!-- Latest Posts Section -->
    <div class="sidebar__single sidebar__post">
        <h3 class="sidebar__title">Latest posts</h3>
        <ul class="sidebar__post-list list-unstyled">
            @foreach($latestPosts as $post)
                <li>
                    <div class="sidebar__post-image">
                        <img src="{{ $post['_embedded']['wp:featuredmedia'][0]['source_url'] }}" alt="">
                    </div>
                    <div class="sidebar__post-content">
                        <h3>
                            <span class="sidebar__post-content-meta"><i class="fa fa-clock"></i>{{ \Carbon\Carbon::parse($post['date'])->format('d M, Y') }}</span>
                            <a href="/blog/{{ $post['slug'] }}">{{ $post['title']['rendered'] }}</a>
                        </h3>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Categories Section -->
    <div class="sidebar__single sidebar__category">
        <h3 class="sidebar__title">Categories</h3>
        <ul class="sidebar__category-list list-unstyled">
            @foreach($categories as $category)
            <li><a href="{{ route('blog.index', ['category' => $category['id']]) }}">{!! $category['name'] !!}<span class="fas fa-caret-right"></span></a></li>

            @endforeach
        </ul>
    </div>

    <!-- Tags Section -->
    <div class="sidebar__single sidebar__tags">
        <h3 class="sidebar__title">Tags</h3>
        <div class="sidebar__tags-list">
            @foreach($tags as $tag)
                <a href="{{ route('blog.index', ['tag' => $tag['id']]) }}">{{ $tag['name'] }}</a>
            @endforeach
        </div>
    </div>
</div>
