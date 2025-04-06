@extends('layouts.app')

@section('title', 'Blog - Gallery App')

@section('content')

@php
    $Title = 'Home';
    $Title2 = 'Blog';
    $SubTitle = "Blog";
@endphp

@include('partials.Page_Header')

<section class="blog-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="blog-sidebar__left">
                    <div class="blog-sidebar__content-box">
                        @foreach($blogs as $blog)
                            <!-- ..::Blog sidebar Single Start ::.. -->
                            <div class="blog-sidebar__single">
                                <div class="blog-sidebar__img">
                                    @if(isset($blog['_embedded']['wp:featuredmedia'][0]['source_url']))
                                        <img src="{{ $blog['_embedded']['wp:featuredmedia'][0]['source_url'] }}" alt="{{ $blog['title']['rendered'] }}">
                                    @else
                                        <img src="default-image.jpg" alt="No Image Available">
                                    @endif
                                    <div class="blog-sidebar__date-box">
                                        <span>{{ date('d', strtotime($blog['date'])) }}</span>
                                        <p>{{ date('F Y', strtotime($blog['date'])) }}</p>
                                    </div>
                                </div>
                                <div class="blog-sidebar__content">
                                    <ul class="blog-sidebar__meta list-unstyled">
                                        <li>
                                            @if(isset($blog['_embedded']['author'][0]['name']))
                                                <a href="#"><i class="fas fa-user-circle"></i>by {{ $blog['_embedded']['author'][0]['name'] }}</a>
                                            @endif
                                        </li>
                                    </ul>
                                    <h3 class="blog-sidebar__title">
                                        <a href="/blog/{{ $blog['slug'] }}">{{ $blog['title']['rendered'] }}</a>
                                    </h3>
                                    <p class="blog-sidebar__text">
                                        {!! Str::limit(strip_tags($blog['excerpt']['rendered']), 150) !!}
                                    </p>
                                    <div class="blog-sidebar__btn">
                                        <a href="/blog/{{ $blog['slug'] }}">More <span class="fa fa-play"></span></a>
                                    </div>
                                </div>
                            </div>
                            <!-- ..::Blog sidebar Single End ::.. -->
                        @endforeach
                    </div>
                    <!-- Pagination -->

                    <!-- Pagination -->
                    <div class="project-details__pagination-box">
                        <ul class="project-details__pagination justify-content-center list-unstyled clearfix">
                            <li>
                                <ul class="counts">
                                    <!-- Previous Button -->
                                    <li class="count {{ $currentPage == 1 ? 'disabled' : '' }}">
                                        <a href="/blog/?page={{ max($currentPage - 1, 1) }}"><i class="icon-left-arrow"></i></a>
                                    </li>

                                    <!-- Page Number Links -->
                                    @for ($i = 1; $i <= $totalPages[0]; $i++)
                                        <li class="count {{ $currentPage == $i ? 'active' : '' }}">
                                            <a href="/blog/?page={{ $i }}">
                                                <span>{{ $i }}</span>
                                            </a>
                                        </li>
                                    @endfor

                                    <!-- Next Button -->
                                    <li class="count {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                        <a href="/blog/?page={{ min($currentPage + 1, $totalPages) }}"><i class="icon-right-arrow"></i></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                
                @include('partials.blog-sidebar', [
                    'categories' => $categories,
                    'tags' => $tags,
                    'latestPosts' => $latestPosts,
                    'search' => request()->get('search')
                ])
            </div>
        </div>
    </div>
</section>

@endsection
