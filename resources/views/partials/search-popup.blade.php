<div class="search-popup">
    <div class="search-popup__overlay search-toggler"></div>
    <!-- ..:: /.search-popup__overlay  ::.. -->
    <div class="search-popup__content">
        <form action="{{ route('search') }}" method="GET">
            <label for="search" class="sr-only">search here</label>
            <input
                type="text"
                id="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Search Here..."
                required
            />
            <button type="submit" aria-label="search submit" class="thm-btn">
                <i class="icon-magnifying-glass"></i>
            </button>
        </form>
    </div>
    <!-- ..:: /.search-popup__content  ::.. -->
</div>
