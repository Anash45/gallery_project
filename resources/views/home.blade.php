@extends('layouts.app')

@section('title', 'Home - Gallery App')

@php

use App\Helpers\PlatformHelper;

echo PlatformHelper::isAndroid();
@endphp
@section('content')
<section class="projects-page">
    <div class="container">
        @include('partials.search-container')
        <div class="section-title text-center mt-4">
            <h2 class="section-title__title">Recently Added</h2>
        </div>
        <div class="row justify-content-center gallery-row" id="image-wrapper">
            @include('partials.image_with_ads', ['recentImages' => $recentImages, 'recentAds' => $recentAds])
        </div>

        <div id="loader" class="text-center my-4" style="display: none;">
            <p>Loading more...</p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    let offset = {{ count($recentImages) }};
let isLoading = false;
let loadedIds = [
    @foreach($recentImages as $image)
        {{ $image->central_id }},
    @endforeach
];

const loadMoreImages = () => {
    if (isLoading) return;

    isLoading = true;
    document.getElementById('loader').style.display = 'block';

    fetch(`{{ route('home.loadMore') }}?offset=${offset}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            offset: offset,
            loadedIds: loadedIds
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.html.trim() !== '') {
            document.getElementById('image-wrapper').insertAdjacentHTML('beforeend', data.html);
            offset += 20;

            // Add the new loaded image IDs to our list
            loadedIds = loadedIds.concat(data.newLoadedIds);
        }
        isLoading = false;
        document.getElementById('loader').style.display = 'none';
    });
};

window.addEventListener('scroll', () => {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100 && !isLoading) {
        loadMoreImages();
    }
});

</script>
@endpush
