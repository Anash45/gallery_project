<div class="position-relative search-popup__content page-search-container psc mt-3">
    <div>
        <form class="custom-search-form d-flex flex-column gap-2" action="" method="GET">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="position-relative">
                        <label for="search" class="sr-only">Search here</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" id="search" class="search-input" value="{{ $query ?? '' }}"
                                placeholder="Search Here..." required />
                            <button type="submit" aria-label="search submit" class="thm-btn">
                                <i class="icon-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    {{-- Sort Dropdown --}}
                    <div class="contact-page__input-box">
                        <div class="contact-page__showing-sort">
                            <select class="selectpicker" name="sort" onchange="this.form.submit()" aria-label="Sort by">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Most Viewed</option>
                                <option value="most_downloaded" {{ request('sort') == 'most_downloaded' ? 'selected' : '' }}>Most Downloaded</option>
                                <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A - Z</option>
                                <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Z - A</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        {{-- Final Tags --}}
        @if (isset($finalTags) && count($finalTags) > 0)
            <p class="blog-details__tags gap-1 d-flex flex-wrap mt-2">
                @foreach ($finalTags as $tag)
                    <a href="/search/{{ urlencode($tag) }}" class="mx-0">{{ $tag }}</a>
                @endforeach
            </p>
        @endif
    </div>
</div>
