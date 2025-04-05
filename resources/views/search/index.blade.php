@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '"')

@section('content')
@php
    $Title = 'Search';
    $Title2 = 'Results';
    $SubTitle = 'Showing results for "' . $query . '"';
@endphp

@include('partials.Page_Header')

<section class="projects-page">
    <div class="container">
        @if($galleryItems->count())
            <div class="mb-4 text-center">
                @php
                    $from = $galleryItems->firstItem();
                    $to = $galleryItems->lastItem();
                    $total = $galleryItems->total();
                    $currentPage = $galleryItems->currentPage();
                    $lastPage = $galleryItems->lastPage();
                @endphp

                <p class="text-end">Showing {{ $from }} to {{ $to }} of {{ $total }} images on page {{ $currentPage }} of {{ $lastPage }}</p>
            </div>

            <div class="row">
                @foreach($galleryItems as $item)
                    @include('partials.image_card', ['item' => $item])
                @endforeach
            </div>

            {{-- Pagination --}}
            @include('vendor.pagination.custom-pagination', ['paginator' => $galleryItems])

        @else
            <div class="text-center py-5">
                <h4 class="text-white">No results found for "<strong>{{ $query }}</strong>"</h4>
            </div>
        @endif
    </div>
</section>
@endsection
