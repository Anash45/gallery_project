@extends('layouts.app')

@php
$blog_title = $blog['title']['rendered'] ?? 'Blog Details';
$blog_excerpt = $blog['excerpt']['rendered'] ?? 'No content available.';
@endphp

@section('title', $blog_title.' - Gallery App')
@section('description', $blog_excerpt.' - Gallery App')

@section('content')

@php
    $Title = 'Home';
    $Title2 = 'Blog';
    $SubTitle = $blog_title;

    $tags = $blog["_embedded"]["wp:term"][1] ?? [];

@endphp

@include('partials.Page_Header')

<section class="blog-details">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7 mx-auto">
                <div class="blog-details__left">
                    <div class="blog-details__img-box">
                        <!-- Dynamic Blog Image -->
                        <img src="{{ $blog['_embedded']['wp:featuredmedia'][0]['source_url'] ?? asset("assets/images/blog/blog-details-img-1.jpg") }}" alt="">
                        <div class="blog-details__date-box">
                            <!-- Dynamic Date -->
                            <span>{{ \Carbon\Carbon::parse($blog['date'])->format('d') }}</span>
                            <p>{{ \Carbon\Carbon::parse($blog['date'])->format('F Y') }}</p>
                        </div>
                    </div>
                    <div class="blog-details__content">
                        <ul class="blog-details__meta list-unstyled">
                            <li>
                                <a href="blog-details.php"><i class="fas fa-user-circle"></i>by Admin</a>
                            </li>
                        </ul>
                        <!-- Dynamic Title -->
                        <h3 class="blog-details__title text-white">{{ $blog['title']['rendered'] }}</h3>
                        <div class="blog-content">
                            <!-- Dynamic Content -->
                            <p class="blog-details__text-1">{!! $blog['content']['rendered'] !!}</p>
                        </div>
                    </div>
                    <div class="blog-details__bottom">
                        <p class="blog-details__tags d-flex flex-wrap gap-2">
                            <span class="text-white">Tags</span>
                            <!-- Dynamic Tags -->
                            @foreach ($tags as $tag)
                                <a href="/blog/?tag={{ $tag['id'] }}" class="mx-0">{{ $tag['name'] }}</a>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
