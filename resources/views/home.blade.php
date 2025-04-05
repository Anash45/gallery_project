@extends('layouts.app')

@section('title', 'Home - Gallery App')

@section('content')
<section class="projects-page">
    <div class="container">
        <div class="section-title text-center mt-5">
            <h2 class="section-title__title">Recently Added</h2>
        </div>
        <div class="row">
            @foreach($recentImages as $item)
                @include('partials.image_card', ['item' => $item])
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
                @foreach($category->galleryItems as $item)
                    @include('partials.image_card', ['item' => $item])
                @endforeach
            </div>
        </div>
    </section>
@endforeach
@endsection
