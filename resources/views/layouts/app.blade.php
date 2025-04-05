<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Dynamic title with default fallback --}}
    <title>@yield('title', config('app.name', 'Gallery App'))</title>
    <meta name="description" content="@yield('description', 'Default description for the gallery app')">
    <meta name="keywords" content="@yield('keywords', 'gallery, images, photos')">
    
    {{-- Meta tags and head content --}}
    @include('partials.head')
    
    {{-- Main CSS Files --}}
    <link rel="stylesheet" href="{{ asset('assets/css/pitoon-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
    
    {{-- Additional CSS from child views --}}
    @stack('styles')
    
    {{-- Inline styles if needed --}}
    @stack('inline-css')
</head>

<body class="custom-cursor">
    {{-- Cursor effect --}}
    @include('partials.cursor')
    
    {{-- Preloader --}}
    @include('partials.preloader')
    
    <div class="page-wrapper">
        {{-- Header with categories dropdown --}}
        @include('partials.header')
        
        {{-- Main content area --}}
        <main>
            {{-- Dynamic content section --}}
            @yield('content')
            
            {{-- Optional hero section --}}
            @hasSection('hero')
                @yield('hero')
            @endif
        </main>
        
        {{-- Footer --}}
        @include('partials.footer')
    </div>
    
    {{-- Mobile navigation --}}
    @include('partials.mobile-nav')
    
    {{-- Search popup --}}
    @include('partials.search-popup')
    
    {{-- Scroll to top button --}}
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <i class="icon-up-arrow"></i>
    </a>
    
    {{-- Main scripts --}}
    @include('partials.script')
    <script src="{{ asset('assets/js/pitoon.js') }}"></script>
    
    {{-- Additional scripts from child views --}}
    @stack('scripts')
    
    {{-- Inline scripts if needed --}}
    @stack('inline-scripts')
</body>
</html>