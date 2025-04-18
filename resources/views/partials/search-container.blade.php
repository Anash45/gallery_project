<div class="position-relative search-popup__content page-search-container psc mt-3">
    <div>
        <form class="custom-search-form d-flex flex-column gap-2" action="" method="GET">
            <div class="row gap-lg-0 gap-4">
                <div class="col-xl-9 col-lg-8 flex-grow-1">
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
                @if (Request::is('search/*'))
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
                @endif
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
        
        @if (Request::is('/'))
            <div class="d-flex flex-column gap-2 mt-3">
                <h4 class="text-white h6">Trending searches <svg class="ms-2" width="16" height="16" viewBox="0 0 15 15" fill="white" xmlns="http://www.w3.org/2000/svg"><path class="fill-icon-primary" d="M1.4 15L0 13.6L11.6 2H5V0H15V10H13V3.4L1.4 15Z"></path></svg></h4>
                <p class="blog-details__tags trending-searches gap-1 d-flex flex-wrap mt-0">
                    @foreach ($trendingSearches as $search)
                        <a href="/search/{{ urlencode($search) }}" class="mx-0">{{ $search }}</a>
                    @endforeach
                </p>
            </div>
        @endif
    </div>
</div>
