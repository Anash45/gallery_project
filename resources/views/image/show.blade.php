@extends('layouts.app')

@section('title', $image->image_name . ' - Gallery App')
@section('description', $image->description)
@section('keywords', $image->tags)

@section('content')
@php
    $Title='Home';
    $Title2 = 'Category';
    $SubTitle = null;

@endphp
@include('partials.Page_Header')

<section class="team-details border-bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="team-details__left">
                    <div class="team-details__img">
                        <img src="{{ $image->database->base_url }}upload/{{ $image->image }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="team-details__right">
                @php
                    // Get liked images from the cookie
                    $likedImages = json_decode(Cookie::get('liked_images', '[]'), true);
                    //print_r($likedImages);
                @endphp
                    <div class="d-flex gap-3 justify-content-between align-items-center">
                        <h3 class="team-details__name text-white">{{ $image->image_name }}</h3>
                    </div>
                    <a href="{{ route('categories.show', $category->slug) }}" class="team-details__sub-title text-white text-decoration-underline">{{ $category->category_name }}</a>
                    <p class="team-details__text-1 text-white">{{ $image->description }}</p>
                    <div class="border-bottom mb-3"></div>
                    <ul class="ps-0 list-unstyled mb-3">
                        <li>
                            <div class="d-flex items-center gap-2 text-white">
                                <strong>Size: </strong> <p>{{ $image->image_size }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex items-center gap-2 text-white">
                                <strong>Resolution: </strong> <p>{{ $image->image_resolution }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex items-center gap-2 text-white">
                                <strong>Views: </strong> <p>{{ $image->view_count }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex items-center gap-2 text-white">
                                <strong>Downloaded: </strong> <p>{{ $image->download_count }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex items-center gap-2 text-white">
                                <strong>Extension: </strong> <p>{{ $image->image_extension }}</p>
                            </div>
                        </li>
                    </ul>
                    <a href="{{ route('image.download', $image->slug) }}" class="thm-btn login-page__form-btn">Download <i class="fa fa-download ms-2"></i></a>
                    <div class="mt-3 d-flex flex-wrap gap-3">
                        <button type="button" class="thm-btn border-0" data-bs-toggle="modal" data-bs-target="#shareModal"
                            onclick="prepareShareModal('{{ $image->title }}', '{{ url()->current() }}')">
                            Share
                            <i class="fa fa-share-square"></i> 
                        </button>
                        <!-- Like Button -->
                        <button type="button" id="like-button-{{ $image->slug }}"
                        onclick="toggleLike('{{ $image->slug }}')" class="thm-btn border-0">
                            <i class="fa fa-thumbs-up h3 cursor-pointer {{ in_array($image->slug, $likedImages ?? []) ? 'text-danger' : '' }}">
                        </i> 
                        </button>
                    </div>

                    @if ($image->database->packageName != '')
                        <div id="play-store-button" class="mt-3" style="display: none;">
                            <a href="https://play.google.com/store/apps/details?id={{ $image->database->packageName }}" target="_blank">
                                <img src="{{ asset('/assets/images/play-store-button.webp') }}" style="height: 55px;" />
                            </a>
                        </div>
                    @endif

                    <div class="blog-details__bottom">
                        <p class="blog-details__tags gap-1 d-flex flex-wrap">
                            <span class="text-white">Tags</span>
                            @foreach(explode(",",$image->tags) as $tag)
                            <a href="{{ route('search', ['query' => urlencode(trim($tag))]) }}" class="mx-0">{{ $tag }}</a>
                            @endforeach
                        </p>
                    </div>

                    @if (count($otherCategories) > 0)
                        <div class="d-flex flex-wrap items-center gap-2">
                            @foreach ($otherCategories as $oc )
                                <a href="{{ route('categories.show', $oc->slug) }}" class="thm-btn border-0">
                                    <span>{{ $oc->category_name }}</span>
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            @endforeach     
                        </div>               
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<section class="projects-page mt-0 pt-0">
    <div class="container">
        <div class="section-title text-center mt-4">
            <h2 class="section-title__title">Related Images</h2>
        </div>
        <div class="row justify-content-center gallery-row" id="related-image-wrapper"></div>
        <div id="related-loader" class="text-center my-4" style="display: none;">
            <p>Loading related images...</p>
        </div>
    </div>
</section>
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share this image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center gap-3 mb-3 fs-4">
                    <a id="share-whatsapp" href="#" target="_blank" class="text-success">
                        <i class="fab fa-whatsapp" style="font-size: 36px;"></i>
                    </a>
                    <a id="share-facebook" href="#" target="_blank" class="text-primary">
                        <i class="fab fa-facebook" style="font-size: 36px;"></i>
                    </a>
                    <a id="share-twitter" href="#" target="_blank" class="text-info">
                        <i class="fab fa-twitter" style="font-size: 36px;"></i>
                    </a>
                    <a id="share-telegram" href="#" target="_blank" class="text-primary">
                        <i class="fab fa-telegram" style="font-size: 36px;"></i>
                    </a>
                </div>
                <button class="thm-btn w-100 border-0 py-2 mt-2" onclick="openNativeShare()">
                    <i class="fas fa-share-alt me-1"></i> More...
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const isAndroid = /Android/i.test(navigator.userAgent);
        if (isAndroid) {
            document.getElementById('play-store-button').style.display = 'block';
        }
    });
</script>
@endpush
@push('scripts')
<script>
let relatedOffset = 0;
let relatedLoading = false;
let relatedLoadedIds = [];

const loadRelatedImages = () => {
    if (relatedLoading) return;
    relatedLoading = true;
    document.getElementById('related-loader').style.display = 'block';

    fetch(`/image/{{ $image->slug }}/related`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            offset: relatedOffset,
            loadedIds: relatedLoadedIds
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.html.trim() !== '') {
            document.getElementById('related-image-wrapper').insertAdjacentHTML('beforeend', data.html);
            relatedOffset += 12;

            // Update the loaded IDs
            relatedLoadedIds = relatedLoadedIds.concat(data.newLoadedIds);
        }
        relatedLoading = false;
        document.getElementById('related-loader').style.display = 'none';
    });
};

// Initial load
loadRelatedImages();

// Load more when scrolling near bottom
window.addEventListener('scroll', () => {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 300 && !relatedLoading) {
        loadRelatedImages();
    }
});

</script>
<script>
    function prepareShareModal(title, url) {
        document.getElementById('share-whatsapp').href = `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`;
        document.getElementById('share-facebook').href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
        document.getElementById('share-twitter').href = `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`;
        document.getElementById('share-telegram').href = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
    }

    function openNativeShare() {
        const title = document.title;
        const url = window.location.href;

        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            }).then(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('shareModal'));
                modal.hide();
            }).catch(err => {
                console.log('Error sharing:', err);
            });
        } else {
            alert("Your browser doesn't support native sharing.");
        }
    }
</script>
<script>
function toggleLike(slug) {
    // Send an AJAX request to toggle like/unlike
    fetch('{{ route('like.image') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ slug: slug })
    })
    .then(response => response.json())
    .then(data => {
        // Update icon color based on liked state
        const button = document.getElementById('like-button-' + slug);
        if (data.liked) {
            button.querySelector('i').classList.add('text-danger');
        } else {
            button.querySelector('i').classList.remove('text-danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}    
</script>


@endpush
