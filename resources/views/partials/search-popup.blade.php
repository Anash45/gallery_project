<div class="search-popup">
    <div class="search-popup__overlay search-toggler"></div>
    <div class="search-popup__content">
        <form id="custom-search-form" class="custom-search-form" action="" method="GET">
            <label for="search" class="sr-only">search here</label>
            <input
                type="text"
                id="search"
                class="search-input"
                name="q"
                value="{{ $query ?? ""}}"
                placeholder="Search Here..."
                required
            />
            <button type="submit" aria-label="search submit" class="thm-btn">
                <i class="icon-magnifying-glass"></i>
            </button>
        </form>
    </div>
</div>

@push('scripts')
@endpush
