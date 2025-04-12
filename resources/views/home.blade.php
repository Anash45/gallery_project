@extends('layouts.app')

@section('title', 'Home - Gallery App')

@section('content')
<section class="projects-page">
    <div class="container">
        @include('partials.search-container')
        <div class="section-title text-center mt-4">
            <h2 class="section-title__title">Recently Added</h2>
        </div>
        <div class="row justify-content-center" id="image-wrapper">
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

    const loadMoreImages = () => {
        if (isLoading) return;

        isLoading = true;
        document.getElementById('loader').style.display = 'block';

        fetch(`{{ route('home.loadMore') }}?offset=${offset}`)
            .then(res => res.json())
            .then(data => {
                if (data.html.trim() !== '') {
                    document.getElementById('image-wrapper').insertAdjacentHTML('beforeend', data.html);
                    offset += 20;
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
