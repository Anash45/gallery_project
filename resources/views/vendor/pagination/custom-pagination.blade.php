<div class="project-details__pagination-box">
    <ul class="project-details__pagination justify-content-center list-unstyled clearfix">
        <li>
            <ul class="counts">
                {{-- Previous Page Link --}}
                @if ($galleryItems->onFirstPage())
                    <li class="count disabled"><a href="#"><i class="icon-left-arrow"></i></a></li>
                @else
                    <li class="count">
                        <a href="{{ isset($query) ? str_replace('%2B', '+', $galleryItems->previousPageUrl()) : $galleryItems->previousPageUrl() }}">
                            <i class="icon-left-arrow"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $currentPage = $galleryItems->currentPage();
                    $lastPage = $galleryItems->lastPage();
                    $range = 3; // Show 3 pages before and after the current page
                    $start = max($currentPage - $range, 1); // Start of range
                    $end = min($currentPage + $range, $lastPage); // End of range

                    // Ensure the range doesn't go out of bounds (1-3 pages before and after current)
                    if ($currentPage < 4) {
                        $end = min($lastPage, 7); // For the first pages
                    } elseif ($currentPage > $lastPage - 3) {
                        $start = max(1, $lastPage - 6); // For the last pages
                    }
                @endphp

                {{-- Pagination Elements --}}
                @for ($page = $start; $page <= $end; $page++)
                    <li class="count @if ($page == $currentPage) active @endif">
                        <a href="{{ isset($query) ? str_replace('%2B', '+', $galleryItems->url($page)) : $galleryItems->url($page) }}">
                            <span>{{ $page }}</span>
                        </a>
                    </li>
                @endfor

                {{-- Show "..." if there are more pages after the last visible page --}}
                @if ($end < $lastPage)
                    <li class="count">...</li>
                @endif

                {{-- Next Page Link --}}
                @if ($galleryItems->hasMorePages())
                    <li class="count">
                        <a href="{{ isset($query) ? str_replace('%2B', '+', $galleryItems->nextPageUrl()) : $galleryItems->nextPageUrl() }}">
                            <i class="icon-right-arrow"></i>
                        </a>
                    </li>
                @else
                    <li class="count disabled"><a href="#"><i class="icon-right-arrow"></i></a></li>
                @endif
            </ul>
        </li>
    </ul>
</div>
