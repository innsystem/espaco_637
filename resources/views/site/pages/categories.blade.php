@extends('site.base')

@section('title', 'Eventos - Espaço 637')

@section('meta_description', 'Confira nossa galeria completa de eventos realizados no Espaço 637. Casamentos, aniversários, eventos corporativos e muito mais. Cada celebração é única, assim como nosso espaço.')

@section('og_title', 'Galeria de Eventos - Espaço 637')

@section('og_description', 'Confira nossa galeria completa de eventos realizados no Espaço 637. Casamentos, aniversários, eventos corporativos e muito mais. Cada celebração é única, assim como nosso espaço.')

@section('og_image', asset('galerias/espaco637/hero-ranch.jpg'))

@section('twitter_title', 'Galeria de Eventos - Espaço 637')

@section('twitter_description', 'Confira nossa galeria completa de eventos realizados no Espaço 637. Casamentos, aniversários, eventos corporativos e muito mais. Cada celebração é única, assim como nosso espaço.')

@section('twitter_image', asset('galerias/espaco637/hero-ranch.jpg'))

@section('content')
<!-- Hero Section -->
<section class="page-hero">
    <div class="hero-background" style="background-image: url('{{ asset('galerias/espaco637/02.jpg') }}')">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">Nossos Eventos</h1>
                    <p class="hero-subtitle">Cada celebração é única, assim como nosso espaço</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Category Filter Section -->
<section class="category-filter-section py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h4 class="mb-3">Filtrar por Categoria</h4>
                    <div class="category-buttons">
                        <a href="{{ route('site.categories.index') }}" class="btn {{ !isset($selectedCategory) ? 'btn-primary' : 'btn-outline-primary' }} me-2 mb-2">
                            Todos os Eventos
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('site.categories.index', ['category' => $category->slug]) }}"
                            class="btn {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'btn-primary' : 'btn-outline-primary' }} me-2 mb-2">
                            {{ $category->title }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Gallery Section -->
<section id="events" class="events-section">
    <div class="container">
        @if(isset($portfoliosByCategory) && $portfoliosByCategory->count() > 0)
        @php
        $groupedPortfolios = $portfoliosByCategory->groupBy('category_id');
        @endphp

        @foreach($groupedPortfolios as $categoryId => $portfolios)
        @if($portfolios->count() > 0)
        @php
        $category = $portfolios->first()->category;
        $categoryName = $category ? $category->title : 'Eventos';
        @endphp

        <div class="event-category mb-5">
            <div class="text-center mb-4">
                <h3 class="event-category-title">{{ $categoryName }}</h3>
            </div>
            <div class="row g-3">
                @foreach($portfolios as $portfolio)
                @if($portfolio->images && $portfolio->images->count() > 0)
                @foreach($portfolio->images as $image)
                <div class="col-6 col-lg-3">
                    <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="portfolio-{{ $categoryId }}" data-title="{{ $portfolio->title }}">
                        <div class="gallery-item">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E" data-src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $portfolio->title }}" class="gallery-image lazy-load">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                @endif
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
        @endif

        <div class="text-center mt-5">
            <p class="mb-3">Quer ver mais? Visite nosso espaço e descubra todas as possibilidades</p>
            <div class="success-badge">
                <span>+200 eventos realizados com sucesso</span>
            </div>
            <div class="mt-4">
                @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                <a class="btn btn-primary btn-lg" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getSettings['cellphone']) }}" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    Agendar Visita
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('pageMODAL')
@endsection

@section('pageJS')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Lazy Loading para imagens
        const images = document.querySelectorAll('img.lazy-load');

        const observerImages = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.getAttribute('data-src'); // Define o src com o valor de data-src
                    
                    // Adiciona evento para quando a imagem carregar
                    img.onload = function() {
                        img.classList.remove('lazy-load');
                        img.classList.add('loaded');
                    };
                    
                    observerImages.unobserve(img); // Para de observar a imagem
                }
            });
        }, {
            threshold: 0.1 // A imagem será carregada quando 10% da sua área for visível
        });

        images.forEach(image => {
            observerImages.observe(image); // Começa a observar as imagens
        });
    });
</script>

<style>
    /* Garantir que os links sejam clicáveis */
    .gallery-item a {
        position: relative;
        z-index: 10;
        cursor: pointer;
    }

    .btn {
        position: relative;
        z-index: 10;
        cursor: pointer;
    }

    /* Remover qualquer overlay que possa estar bloqueando */
    .gallery-overlay {
        pointer-events: none;
    }

    /* Garantir que os botões de categoria sejam clicáveis */
    .category-buttons .btn {
        position: relative;
        z-index: 10;
        cursor: pointer;
    }

    /* Estilos para Lazy Loading */
    .lazy-load {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        background: #f8f9fa;
        min-height: 200px;
    }

    .lazy-load.loaded {
        opacity: 1;
    }

    /* Placeholder para imagens durante carregamento */
    .gallery-image.lazy-load {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }
</style>
@endsection