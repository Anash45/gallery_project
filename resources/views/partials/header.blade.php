@php
    $categories = \App\Models\Category::where('category_status', 1)
        ->orderBy('category_name')
        ->get();
@endphp 
<header class="main-header">
    <nav class="main-menu">
        <div class="main-menu__wrapper">
            <div class="main-menu__wrapper-inner">
                <div class="main-menu__left flex-grow-1">
                    <div class="main-menu__logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('assets/images/resources/logo-1.png') }}" alt=""></a>
                    </div>
                    <div class="main-menu__main-menu-box mx-auto">
                        <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                        <ul class="main-menu__list">
                            <li class="{{ request()->is('/') ? 'active' : '' }}">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="{{ request()->is('category*') ? 'active' : '' }}">
                                <a href="{{ route('categories.index') }}">Categories</a>
                            </li>
                            <li class="{{ request()->is('/blog/') ? 'active' : '' }}">
                                <a href="{{ route('blog.index') }}">Blog</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="main-menu__right">
                    <div class="main-menu__search-cart-box">
                        <div class="main-menu__search-box">
                            <a href="#" class="main-menu__search search-toggler icon-magnifying-glass"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>