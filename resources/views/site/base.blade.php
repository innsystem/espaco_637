<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('title') | Lâminas Naturais e Compostas de Alta Qualidade para Seus Projetos.">
    <!-- Title-->
    <title>@yield('title') | {{$getSettings['site_name'] ?? 'Espaço 637'}}</title>
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ $getSettings['favicon'] ?? '' ? asset('storage/' . $getSettings['favicon']) : asset('favicon.png') }}" type="image/x-icon">

    <link rel="manifest" href="{{ asset('tpl_site/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('tpl_site/img/favicons/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Google Fonts - Optimized -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100..900;1,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100..900;1,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet"></noscript>

    <!-- Critical CSS - Keep render-blocking -->
    <link rel="stylesheet" href="{{ asset('tpl_site/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tpl_site/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('tpl_site/css/custom_template.css?8'.rand()) }}">
    
    <!-- Non-Critical CSS - Defer loading -->
    <link rel="preload" href="{{ asset('tpl_site/css/fontawesome.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('tpl_site/css/fontawesome.min.css') }}"></noscript>
    
    <link rel="preload" href="{{ asset('tpl_site/css/magnific-popup.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('tpl_site/css/magnific-popup.min.css') }}"></noscript>
    
    <link rel="preload" href="{{ asset('tpl_site/css/swiper-bundle.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('tpl_site/css/swiper-bundle.min.css') }}"></noscript>

    @yield('pageCSS')

    @if($getSettings['script_head'] && $getSettings['script_head'] != '')
        {!! $getSettings['script_head'] !!}
    @endif
</head>

<body class="home-luxury-hotel-2 bg-repeat">
    @if($getSettings['script_body'] && $getSettings['script_body'] != '')
        {!! $getSettings['script_body'] !!}
    @endif
    <!-- slider drag cursor -->
    <div class="slider-drag-cursor"><i class="fal fa-arrows-up-down-left-right"></i></div>

    <!--==============================
 Preloader
==============================-->
    <div class="preloader ">
        <div id="preloader" class="preloader-inner">
            <img src="{{ asset('/galerias/favicon.png') }}" alt="img">
            <div class="txt-loading">
                <span data-text-preloader="E" class="letters-loading">
                    E </span>
                <span data-text-preloader="S" class="letters-loading">
                    S </span>
                <span data-text-preloader="P" class="letters-loading">
                    P </span>
                <span data-text-preloader="A" class="letters-loading">
                    A </span>
                <span data-text-preloader="Ç" class="letters-loading">
                    Ç
                </span>
                <span data-text-preloader="O" class="letters-loading">
                    O
                </span>
                <span data-text-preloader=" " class="letters-loading">
                    &nbsp;
                </span>
                <span data-text-preloader="6" class="letters-loading">
                    6
                </span>
                <span data-text-preloader="3" class="letters-loading">
                    3
                </span>
                <span data-text-preloader="7" class="letters-loading">
                    7
                </span>
            </div>
        </div>
    </div>

    <!--==============================
    Sidemenu
============================== -->
    <div class="sidemenu-wrapper ">
        <div class="sidemenu-content allow-natural-scroll">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="sidemenu-layout">
                <div class="th-side-menu">
                    <div class="side-logo">
                        <a href="{{ route('site.index') }}"><img src="{{ asset('/galerias/logo_espaco637_white.webp') }}" alt="Espaço 637" style="max-width:160px;"></a>
                    </div>
                    <ul>
                        <li class="">
                            <a href="{{ route('site.index') }}">Início</a>
                        </li>
                        <li>
                            <a href="{{ route('site.about') }}">Sobre Nós</a>
                        </li>
                        <li>
                            <a href="{{ route('site.categories.index') }}">Lâminas</a>
                        </li>
                        <li>
                            <a href="{{ route('site.services') }}">Serviços</a>
                        </li>
                        <li>
                            <a href="{{ route('site.sustainability') }}">Sustentabilidade</a>
                        </li>
                    </ul>

                </div>
                <div class="widget side-menu-contact pt-80 footer-widget">
                    <h3 class="widget_title">Entre em Contato</h3>
                    <div class="th-widget-contact">
                        @if(isset($getSettings['address']) && $getSettings['address'] != '')
                        <div class="info-box">
                            <div class="box-icon">
                                <i class="fal fa-location-dot"></i>
                            </div>
                            <p class="box-text">{{$getSettings['address']}}</p>
                        </div>
                        @endif
                        @if(isset($getSettings['telephone']) && $getSettings['telephone'] != '')
                        <div class="info-box">
                            <div class="box-icon">
                                <i class="fal fa-phone"></i>
                            </div>
                            <p class="box-text">
                                <a href="tel:{{$getSettings['telephone']}}" class="box-link">{{$getSettings['telephone']}}</a>
                            </p>
                        </div>
                        @endif
                        @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                        <div class="info-box">
                            <div class="box-icon">
                                <i class="fab fa-whasapp"></i>
                            </div>
                            <p class="box-text">
                                <a href="https://wa.me/@formatPhone($getSettings['cellphone'])" target="_Blank" class="box-link">{{$getSettings['cellphone']}}</a>
                            </p>
                        </div>
                        @endif
                        @if(isset($getSettings['site_email']) && $getSettings['site_email'] != '')
                        <div class="info-box">
                            <div class="box-icon">
                                <i class="fal fa-envelope"></i>
                            </div>
                            <p class="box-text">
                                <a href="mailto:{{$getSettings['site_email']}}" class="box-link">{{$getSettings['site_email']}}</a>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!--==============================
	Header Area
==============================-->
    <header class="th-header header-layout4 ">
        <div class="header-top d-none d-lg-block">
            <div class="container th-container2">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto">
                        <div class="header-links d-none d-lg-inline-block">
                            <ul>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-links">
                            <ul>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container th-container2">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto d-xxl-none d-block">
                            <div class="header-wrapp">
                                <div class="header-button">
                                    <a href="#" class="simple-btn sideMenuToggler"><i
                                            class="fa-sharp-duotone far fa-bars me-2"></i><span
                                            class="menu">MENU</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto ms-auto d-none d-xl-block">
                            <div class="header-wrapp">
                                <nav class="main-menu">
                                    <ul>
                                        <li>
                                            <a href="{{ route('site.about') }}">EMPRESA</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('site.categories.index') }}">LÂMINAS</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="{{ route('site.index') }}">
                                    <img src="{{ asset('/galerias/logo_espaco637_white.webp') }}" alt="Espaço 637">
                                </a>
                                <div class="bg-shape" data-mask-src="{{ asset('tpl_site/img/logo-shape2.png') }}"></div>
                            </div>
                        </div>
                        <div class="col-auto me-auto d-none d-xl-block">
                            <div class="header-wrapp">
                                <nav class="main-menu style3">
                                    <ul>
                                        <li>
                                            <a href="{{ route('site.services') }}">SERVIÇOS</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('site.sustainability') }}">SUSTENTABILIDADE</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="footer-wrapper footer-layout1 footer-layout1-2 bg-light2">
        <div class="container">
            <div class="footer-logo">
                <img class="bg-light2" src="{{ asset('/galerias/logo_espaco637_white.webp') }}" alt="Espaço 637">
            </div>
        </div>
        <div class="widget-area">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget footer-line">
                            <h3 class="widget_title">Sobre o Espaço 637</h3>
                            <div class="th-widget-about style2">
                                <p class="footer-text">O Espaço 637 é uma empresa especializada na comercialização da mais alta qualidade de lâminas de madeira natural. Nossas lâminas são cuidadosamente selecionadas para garantir não apenas beleza, mas também durabilidade e praticidade.    Com um forte compromisso em facilitar o dia a dia de nossos clientes e parceiros estamos sempre prontos para orientar e auxiliá-los na escolha dos produtos mais adequados.  Acreditamos que, ao oferecer o melhor em lâminas, contribuímos para a realização de projetos únicos e inspiradores.</p>
                                <div class="th-social">
                                    @if(isset($getSettings['facebook']) && $getSettings['facebook'] != '')
                                    <a href="https://www.facebook.com/{{ $getSettings['facebook'] }}" target="_Blank"><i class="fab fa-facebook-f"></i></a>
                                    @endif
                                    @if(isset($getSettings['twitter']) && $getSettings['twitter'] != '')
                                    <a href="https://www.twitter.com/{{ $getSettings['twitter'] }}" target="_Blank"><i class="fab fa-twitter"></i></a>
                                    @endif
                                    @if(isset($getSettings['linkedin']) && $getSettings['linkedin'] != '')
                                    <a href="https://www.linkedin.com/{{ $getSettings['linkedin'] }}" target="_Blank"><i class="fab fa-linkedin-in"></i></a>
                                    @endif
                                    @if(isset($getSettings['youtube']) && $getSettings['youtube'] != '')
                                    <a href="https://www.youtube.com/{{ $getSettings['youtube'] }}" target="_Blank"><i class="fab fa-youtube"></i></a>
                                    @endif
                                    @if(isset($getSettings['instagram']) && $getSettings['instagram'] != '')
                                    <a href="https://www.instagram.com/{{ $getSettings['instagram'] }}" target="_Blank"><i class="fab fa-instagram"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Entre em Contato</h3>
                            <div class="th-widget-contact">
                                @if(isset($getSettings['address']) && $getSettings['address'] != '')
                                <div class="info-box">
                                    <div class="box-icon">
                                        <i class="fal fa-location-dot"></i>
                                    </div>
                                    <p class="box-text">{{ $getSettings['address'] }}</p>
                                </div>
                                @endif
                                @if(isset($getSettings['telephone']) && $getSettings['telephone'] != '')
                                <div class="info-box">
                                    <div class="box-icon">
                                        <i class="fal fa-phone"></i>
                                    </div>
                                    <p class="box-text">
                                        <a href="tel:@formatPhone($getSettings['telephone'])" class="box-link">{{ $getSettings['telephone'] }}</a>
                                    </p>
                                </div>
                                @endif
                                @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                                <div class="info-box">
                                    <div class="box-icon">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <p class="box-text">
                                        <a href="https://wa.me/@formatPhone($getSettings['cellphone'])" target="_Blank" class="box-link">{{ $getSettings['cellphone'] }}</a>
                                    </p>
                                </div>
                                @endif
                                @if(isset($getSettings['site_email']) && $getSettings['site_email'] != '')
                                <div class="info-box">
                                    <div class="box-icon">
                                        <i class="fal fa-envelope"></i>
                                    </div>
                                    <p class="box-text">
                                        <a href="mailto:{{ $getSettings['site_email'] }}" class="box-link">{{ $getSettings['site_email'] }}</a>
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row gy-2 align-items-center">
                    <div class="col-lg-5">
                        <p class="copyright-text">Direitos Autorais <i class="fal fa-copyright"></i> 2025 <a
                                href="{{ route('site.index') }}">Espaço 637</a>. Todos os Direitos Reservados.</p>
                    </div>
                    <div class="col-lg-7 text-end">
                        <p class="copyright-text mb-0">Desenvolvido por <a href="https://innsystem.com.br" target="_Blank" class="text-reset fw-semibold"><img src="{{ asset('/innsystem-logo-light.png') }}" alt="InnSystem" style="max-width: 100px;"></a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @yield('pageMODAL')

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>

    @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
    <div class="whatsapp_futuante pulsaDelay animate__animated animate__tada">
        <a href="https://wa.me/@formatPhone($getSettings['cellphone'])" target="_Blank"><i class="fab fa-whatsapp"></i></a>
    </div>
    @endif

    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <script src="{{ asset('tpl_site/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <!-- Swiper Js -->
    <script src="{{ asset('tpl_site/js/swiper-bundle.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('tpl_site/js/bootstrap.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('tpl_site/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Counter Up -->
    <script src="{{ asset('tpl_site/js/jquery.counterup.min.js') }}"></script>
    <!-- Isotope Filter -->
    <script src="{{ asset('tpl_site/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('tpl_site/js/isotope.pkgd.min.js') }}"></script>
    <!-- Main Js File -->
    <script src="{{ asset('tpl_site/js/main.js') }}"></script>

    @yield('pageJS')
</body>

</html>