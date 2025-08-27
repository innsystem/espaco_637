<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espaço 637 - Eventos Inesquecíveis')</title>
    
    <!-- Meta tags -->
    <meta name="description" content="@yield('meta_description', 'Espaço 637 - Local único para eventos especiais com cervejaria artesanal, inspirado no estilo rancho americano. Ideal para casamentos, aniversários e eventos corporativos.')">
    <meta name="keywords" content="@yield('meta_keywords', 'eventos, casamentos, aniversários, cervejaria artesanal, rancho americano, espaço rústico, Ribeirão Preto')">
    <meta name="author" content="Espaço 637">
    <meta name="robots" content="index, follow">
    <meta name="language" content="pt-BR">
    <meta name="revisit-after" content="7 days">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'Espaço 637 - Eventos Inesquecíveis')">
    <meta property="og:description" content="@yield('og_description', 'Espaço 637 - Local único para eventos especiais com cervejaria artesanal, inspirado no estilo rancho americano. Ideal para casamentos, aniversários e eventos corporativos.')">
    <meta property="og:image" content="@yield('og_image', asset('galerias/logo.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Espaço 637">
    <meta property="og:locale" content="pt_BR">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', 'Espaço 637 - Eventos Inesquecíveis')">
    <meta property="twitter:description" content="@yield('twitter_description', 'Espaço 637 - Local único para eventos especiais com cervejaria artesanal, inspirado no estilo rancho americano. Ideal para casamentos, aniversários e eventos corporativos.')">
    <meta property="twitter:image" content="@yield('twitter_image', asset('galerias/logo.png'))">
    
    <!-- WhatsApp Business -->
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="Espaço 637 - Logo">
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#949e22">
    <meta name="msapplication-TileColor" content="#949e22">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Espaço 637">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('plugins/bootstrap-5.3.5/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('tpl_site/css/espaco637.css?2') }}">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="{{ asset('plugins/animate.min.css') }}">
    
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/lightbox/css/lightbox.css') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
        
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('galerias/favicon.ico') }}">
    
    @yield('pageCSS')
    
    @if($getSettings['script_head'] && $getSettings['script_head'] != '')
        {!! $getSettings['script_head'] !!}
    @endif
</head>
<body>
    @if($getSettings['script_body'] && $getSettings['script_body'] != '')
        {!! $getSettings['script_body'] !!}
    @endif

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('site.index') }}">
                <img src="{{ asset('galerias/logo.png?1') }}" alt="Espaço 637" height="40">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.index') }}">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.index') }}#about">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.categories.index') }}">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.index') }}#services">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.index') }}#products">Cervejas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.index') }}#contact">Contato</a>
                    </li>
                    @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getSettings['cellphone']) }}" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            Agendar Visita
                        </a>
                    </li>
                    @endif
                    
                    <!-- Redes Sociais -->
                    <li class="nav-item ms-lg-2">
                        <div class="navbar-social-links">
                            @if(isset($getSettings['facebook']) && $getSettings['facebook'] != '')
                                <a href="https://facebook.com/{{ $getSettings['facebook'] }}" target="_blank" class="nav-social-link mt-1">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            @endif
                            
                            @if(isset($getSettings['instagram']) && $getSettings['instagram'] != '')
                                <a href="https://instagram.com/{{ $getSettings['instagram'] }}" target="_blank" class="nav-social-link mt-1">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            
                            @if(isset($getSettings['youtube']) && $getSettings['youtube'] != '')
                                <a href="https://youtube.com/{{ $getSettings['youtube'] }}" target="_blank" class="nav-social-link mt-1">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            @endif
                            
                            @if(isset($getSettings['linkedin']) && $getSettings['linkedin'] != '')
                                <a href="https://linkedin.com/in/{{ $getSettings['linkedin'] }}" target="_blank" class="nav-social-link mt-1">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            @endif
                            
                            @if(isset($getSettings['twitter']) && $getSettings['twitter'] != '')
                                <a href="https://twitter.com/{{ $getSettings['twitter'] }}" target="_blank" class="nav-social-link mt-1">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="text-center">
                <div class="footer-logo">
                    <img src="{{ asset('galerias/logo.png') }}" alt="Espaço 637" class="footer-logo-img">
                </div>
                
                <h3 class="footer-title">Espaço 637</h3>
                <p class="footer-description">Onde cada celebração se torna uma memória inesquecível</p>
                
                <div class="footer-divider">
                    <div class="divider-line"></div>
                    <div class="divider-dot"></div>
                    <div class="divider-line"></div>
                </div>
                
                <!-- Redes Sociais -->
                <div class="footer-social mb-4">
                    @if(isset($getSettings['facebook']) && $getSettings['facebook'] != '')
                        <a href="https://facebook.com/{{ $getSettings['facebook'] }}" target="_blank" class="social-link">
                            <i class="fab fa-facebook"></i>
                        </a>
                    @endif
                    
                    @if(isset($getSettings['instagram']) && $getSettings['instagram'] != '')
                        <a href="https://instagram.com/{{ $getSettings['instagram'] }}" target="_blank" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    
                    @if(isset($getSettings['youtube']) && $getSettings['youtube'] != '')
                        <a href="https://youtube.com/{{ $getSettings['youtube'] }}" target="_blank" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                    
                    @if(isset($getSettings['linkedin']) && $getSettings['linkedin'] != '')
                        <a href="https://linkedin.com/in/{{ $getSettings['linkedin'] }}" target="_blank" class="social-link">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    @endif
                    
                    @if(isset($getSettings['twitter']) && $getSettings['twitter'] != '')
                        <a href="https://twitter.com/{{ $getSettings['twitter'] }}" target="_blank" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                </div>
                
                <div class="footer-copyright">
                    <p>© {{ date('Y') }} Espaço 637. Todos os direitos reservados.</p>
                    <p class="footer-credit">Desenvolvido por <a href="https://innsystem.com.br" target="_blank" class="text-black text-decoration-none">InnSystem</a></p>
                </div>
            </div>
        </div>
    </footer>

    @yield('pageMODAL')

    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-5.3.5/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/lightbox/js/lightbox.js') }}"></script>
    <script src="{{ asset('tpl_site/js/espaco637.js?1'.rand()) }}"></script>

    @yield('pageJS')
</body>
</html>