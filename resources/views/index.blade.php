<!DOCTYPE html>
<html lang="en">
    {{-- Set the title --}} @php $title = 'Home One' @endphp {{-- Include head partial --}} @include('partials.head')
    {{-- Link to the CSS file using Laravel asset() helper --}}
    <link rel="stylesheet" href="{{ asset('assets/css/pitoon-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    <body class="custom-cursor">
        {{-- Include cursor partial --}} @include('partials.cursor') {{-- Include preloader partial --}}
        @include('partials.preloader') <!-- ..:: /.preloader  ::.. -->
        <div class="page-wrapper">
            {{-- Include header partial --}} @include('partials.header') <!-- ..:: /.stricky-header  ::.. -->
            <main class="pt-5">
                <section class="project-one">
                    <div class="container">
                        <div class="section-title text-center">
                            <h2 class="section-title__title">Recent Uploads</h2>
                        </div>
                    </div>
                </section>
            </main>
            <!-- ..::Site Footer Start ::.. --> @include('partials.footer') <!-- ..::Site Footer End ::.. -->
        </div><!-- ..:: /.page-wrapper  ::.. -->
        {{-- Include mobile-nav partial --}} @include('partials.mobile-nav') <!-- ..:: /.mobile-nav__wrapper  ::.. -->
        {{-- Include search-popup partial --}} @include('partials.search-popup') <!-- ..:: /.search-popup  ::.. -->
        <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
            <i class="icon-up-arrow"></i>
        </a>
        {{-- Include script partial --}} @include('partials.script')
        {{-- Link to JS file using Laravel asset() helper --}}
        <script src="{{ asset('assets/js/pitoon.js') }}"></script>
    </body>

</html>