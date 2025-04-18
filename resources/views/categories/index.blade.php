@extends('layouts.app')

@section('title',  'Categories - Gallery App')

@section('content')


<section class="projects-page">
        <div class="container">
            <div class="section-title text-center mt-5">
                <h2 class="section-title__title">Categories</h2>
            </div>
            <div class="row categories-row">

                @foreach($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="/subcategory/{{ $category->slug }}" class="project-one__single project-one__category">
                        <div class="project-one__img-box">
                            <div class="project-one__img">
                                <img src="{{ $category->base_url }}upload/category/{{ $category->database_img }}" loading="lazy"
                                    alt="{{ $category->database_name }}" class="w-100">
                            </div>
                            <div class="project-one__content">
                                <div class="project-one__title-box">
                                    <h3 class="project-one__title">{{ $category->database_name }}</h3>
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
