@extends('layouts.app')

@section('title', 'Home - Gallery App')

@section('content')
    <section class="projects-page">
        <div class="container">
            <div class="section-title text-center mt-5">
                <h2 class="section-title__title">Recently Added</h2>
            </div>
            <div class="row">
                @php
                    $imageCount = 0; // Counter for images
                    $minImagesBeforeAd = rand(5, 8); // Random number between 5 and 8 for minimum images before showing ad
                    $adCount = 0; // Counter for ads
                @endphp

                @foreach($recentImages as $index => $item)
                    @include('partials.image_card', ['item' => $item])

                    @php
                        $imageCount++; // Increment image counter
                    @endphp

                    <!-- Show 2 ads after every 5-8 images -->
                    @if ($imageCount >= $minImagesBeforeAd && $adCount < 2)
                        @if ($recentAds->isNotEmpty())
                            <!-- Randomly select and display an ad -->
                            @php
                                $ad = $recentAds->random();  // Randomly select an ad
                            @endphp
                            @include('partials.ad_card', ['ad' => $ad])
                        @endif
                        @php
                            $adCount++; // Increment ad counter
                        @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </section>


    @foreach($categories as $category)
        <section class="category-section py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white fw-semibold">{{ $category->category_name }}</h2>
                    <a href="{{ route('categories.show', $category->slug) }}" class="thm-btn login-page__form-btn py-2">Explore More</a>
                </div>
                <div class="row">
                    @php
                        $imageCount = 0; // Counter for images
                        $minImagesBeforeAd = rand(5, 7); // Random number between 5 and 8 for minimum images before showing ad
                    @endphp

                    @foreach($category->galleryItems as $index => $item)
                        @include('partials.image_card', ['item' => $item])

                        @php
                            $imageCount++; // Increment image counter
                        @endphp

                        <!-- Show ad after every 5-8 images -->
                        @if ($imageCount >= $minImagesBeforeAd)
                            @if ($category->ads->isNotEmpty())
                                <!-- Randomly select and display an ad -->
                                @php
                                    $ad = $category->ads->random();  // Randomly select an ad for the category
                                @endphp
                                @include('partials.ad_card', ['ad' => $ad])
                            @endif
                            @php
                                // Reset counter and set a new random number of images before showing the next ad
                                $imageCount = 0;
                                $minImagesBeforeAd = rand(5, 7); // Reset for next interval
                            @endphp
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endsection
