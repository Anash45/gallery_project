@extends('layouts.app')

@section('title',  'Categories - Gallery App')

@section('content')


<section class="projects-page">
        <div class="container">
            <div class="section-title text-center mt-5">
                <h2 class="section-title__title">Sub Categories</h2>
            </div>
            <div class="row">

                @foreach($categories as $category)
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                    <a href="/category/{{ $category->slug }}" class="project-one__single project-one__category">
                        <div class="project-one__img-box">
                            <div class="project-one__img">
                                <img src="{{ $category->database->base_url }}upload/category/{{ $category->category_image }}" loading="lazy"
                                    alt="{{ $category->category_name }}" class="w-100">
                            </div>
                            <div class="project-one__content">
                                <div class="project-one__title-box">
                                    <h3 class="project-one__title">{{ $category->category_name }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
