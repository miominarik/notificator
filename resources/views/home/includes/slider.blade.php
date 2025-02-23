<section id="hero" class="d-flex flex-column justify-content-end align-items-center">
    <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="carousel-container">
                @if (isset($page))
                    @if ($page == 'gdpr')
                        <h2 class="animate__animated animate__fadeInDown">{{__('home_page.gdpr')}}</h2>
                    @elseif($page == 'cookies')
                        <h2 class="animate__animated animate__fadeInDown">{{__('home_page.cookies')}}</h2>
                    @elseif($page == 'unsubscribe')
                        <h2 class="animate__animated animate__fadeInDown">{{__('home_page.unsubscribe')}}</h2>
                    @endif
                @else
                    <h2 class="animate__animated animate__fadeInDown">{{ __('home_page.header') }}</h2>
                    <p class="animate__animated fanimate__adeInUp">{{ __('home_page.sub_header') }}</p>
                    <a href='https://play.google.com/store/apps/details?id=com.miucode.notificateme&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1' target="_blank"><img alt='Teraz na Google Play' src='https://play.google.com/intl/en_us/badges/static/images/badges/sk_badge_web_generic.png' width="200rem"/></a>
                @endif
            </div>
        </div>

    </div>
    @if (session()->get('emai_send'))
        <div class="alert alert-success" role="alert">
            {{ __('home_page.contact_sended') }}
        </div>
    @endif


    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28 " preserveAspectRatio="none">
        <defs>
            <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
        </defs>
        <g class="wave1">
            <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
        </g>
        <g class="wave2">
            <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
        </g>
        <g class="wave3">
            <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
        </g>
    </svg>



</section>
