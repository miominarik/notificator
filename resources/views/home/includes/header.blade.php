@php use Illuminate\Support\Facades\Cookie; @endphp
<header id="header" class="fixed-top d-flex align-items-center  header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <h1><a href="/">{{ env('APP_NAME') }}</a></h1>
        </div>

        <nav id="navbar" class="navbar">
            @if (request()->is('gdpr') || request()->is('cookies') || request()->is('api/*'))
                <ul>
                    <li><a class="nav-link scrollto" href="/">{{ __('home_page.menu_home') }}</a></li>
                    <li><a class="nav-link scrollto" href="/#services">{{ __('home_page.menu_services') }}</a></li>
                    {{--<li><a class="nav-link scrollto" href="/#pricing">{{ __('home_page.menu_pricing') }}</a></li>--}}
                    <li><a class="nav-link scrollto" href="/#contact">{{ __('home_page.menu_contact') }}</a></li>
                    <div class="vr me-2 ms-2" style="color: white;"></div>
                    @guest
                        <li><a class="nav-link scrollto active" href="/app">{{ __('home_page.menu_login') }}</a></li>
                    @endguest
                    @auth
                        <li><a class="nav-link scrollto active" href="/app">{{ __('home_page.back_to_app') }}</a></li>
                    @endauth
                </ul>
            @else
                <ul>
                    <li><a class="nav-link scrollto" href="#hero">{{ __('home_page.menu_home') }}</a></li>
                    <li><a class="nav-link scrollto" href="#info">{{ __('home_page.information') }}</a></li>
                    <li><a class="nav-link scrollto" href="#services">{{ __('home_page.menu_services') }}</a></li>
                    {{--<li><a class="nav-link scrollto" href="#pricing">{{ __('home_page.menu_pricing') }}</a></li>--}}
                    <li><a class="nav-link scrollto" href="#appinstall">{{ __('home_page.application_install') }}</a>
                    </li>
                    <li><a class="nav-link scrollto"
                           href="#screenshots">{{ __('home_page.application_screenshots') }}</a></li>
                    <li><a class="nav-link scrollto" href="#contact">{{ __('home_page.menu_contact') }}</a></li>
                    <div class="vr me-2 ms-2" style="color: white;"></div>

                    @if(!Cookie::has('token'))
                        <li><a class="nav-link scrollto active" href="/app">{{ __('home_page.menu_login') }}</a></li>
                    @else
                        <li><a class="nav-link scrollto active" href="/app">{{ __('home_page.back_to_app') }}</a></li>
                    @endif
                </ul>
            @endif

            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header>
