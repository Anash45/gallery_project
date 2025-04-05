@extends('layouts.app')

@section('title', $category->category_name . ' - Gallery App')

@section('content')
@php
    $Title='Home';
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
            @foreach($galleryItems as $item)
                @include('partials.image_card', ['item' => $item])
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
