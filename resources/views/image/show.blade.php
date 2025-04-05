@extends('layouts.app')

@section('title', $image->image_name . ' - Gallery App')
@section('description', $image->description)
@section('keywords', $image->tags)

@section('content')
@php
    $Title='Home';
    $Title2 = 'Category';
    $SubTitle = "Image Details";

@endphp
@include('partials.Page_Header')

<section class="team-details">
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
                        <h3 class="team-details__name text-white">{{ $image->image_name }}</h3>
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
                                    <strong>Extension: </strong> <p>{{ $image->image_extension }}</p>
                                </div>
                            </li>
                        </ul>
                        <a href="{{ route('image.download', $image->slug) }}" class="thm-btn login-page__form-btn">Download <i class="fa fa-download ms-2"></i></a>
                        <div class="blog-details__bottom">
                            <p class="blog-details__tags gap-1 d-flex flex-wrap">
                                <span class="text-white">Tags</span>
                                @foreach(explode(",",$image->tags) as $tag)
                                    <a href="{{ route('search', ['q' => trim($tag)]) }}" class="mx-0">{{ $tag }}</a>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
