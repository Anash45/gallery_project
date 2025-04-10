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

        @if ($galleryItems->count())

        <!-- Page Info -->
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

        <!-- Gallery Items + Ads -->
        <div class="row">
            @php
                $adInsertInterval = $adInterval ?? 6;
                $adIndex = 0;
                $adsArray = $ads ?? [];
                $adsCount = count($adsArray);
            @endphp

            @foreach ($galleryItems as $index => $item)
                @include('partials.image_card', ['item' => $item])

                @if (($index + 1) % $adInsertInterval === 0 && $adsCount > 0)
                    @php
                        $ad = $adsArray[$adIndex % $adsCount];
                        $adIndex++;
                    @endphp
                    @include('partials.ad_card', ['ad' => $ad])
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
