@extends('layouts.app')

@section('title', $category->category_name . ' - Gallery App')

@section('content')
@php
    $Title = 'Home';
    $Title2 = 'Category';
    $SubTitle = $category->category_name;
@endphp
@include('partials.Page_Header')

<section class="projects-page">
    <div class="container">
        <!-- Page Information (current page and item range) -->
        @if ($galleryItems->count())
        
        <div class="row mb-4">
            <div class="col-12 text-center">
                @php
                    $from = $galleryItems->firstItem();
                    $to = $galleryItems->lastItem();
                    $total = $galleryItems->total();
                    $currentPage = $galleryItems->currentPage();
                    $lastPage = $galleryItems->lastPage();
                @endphp

                <p class="text-end">Showing {{ $from }} to {{ $to }} of {{ $total }} images on page {{ $currentPage }} of {{ $lastPage }}</p>
            </div>
        </div>

        <!-- Gallery Items -->
        <div class="row">
            @php
                $imageCount = 0; // Counter for images
                $minImagesBeforeAd = rand(5, 8); // Random number between 5 and 8 for minimum images before showing ad
            @endphp

            @foreach($galleryItems as $index => $item)
                @include('partials.image_card', ['item' => $item])

                @php
                    $imageCount++; // Increment image counter
                @endphp

                <!-- Show ad after every 5-8 images -->
                @if ($imageCount >= $minImagesBeforeAd)
                    @if ($ads->isNotEmpty())
                        <!-- Display an ad (you can create a separate partial for the ad) -->
                        @php
                            $ad = $ads->random();  // Randomly select an ad
                        @endphp
                        @include('partials.ad_card', ['ad' => $ad])
                    @endif
                    @php
                        // Reset counter and set a new random number of images before showing the next ad
                        $imageCount = 0;
                        $minImagesBeforeAd = rand(5, 8); // Reset for next interval
                    @endphp
                @endif
            @endforeach
        </div>
        @else
            <div class="text-center py-5">
                <h4 class="text-white">No images present in "<strong>{{ $category->category_name }}</strong>"</h4>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @include('vendor.pagination.custom-pagination', ['paginator' => $galleryItems])
</section>
@endsection
