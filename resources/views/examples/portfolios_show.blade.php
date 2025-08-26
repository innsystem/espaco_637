@extends('site.base')

@section('title', $portfolio->title . ' - Espaço 637')

@section('meta_description', $portfolio->description ?: 'Confira este evento incrível realizado no Espaço 637. ' . $portfolio->title . ' - Um evento único e inesquecível.')

@section('og_title', $portfolio->title . ' - Espaço 637')

@section('og_description', $portfolio->description ?: 'Confira este evento incrível realizado no Espaço 637. ' . $portfolio->title . ' - Um evento único e inesquecível.')

@section('og_image', $portfolio->featured_image ? asset('storage/' . $portfolio->featured_image) : asset('galerias/logo.png'))

@section('twitter_title', $portfolio->title . ' - Espaço 637')

@section('twitter_description', $portfolio->description ?: 'Confira este evento incrível realizado no Espaço 637. ' . $portfolio->title . ' - Um evento único e inesquecível.')

@section('twitter_image', $portfolio->featured_image ? asset('storage/' . $portfolio->featured_image) : asset('galerias/logo.png'))

@section('content')
<!-- Hero Section -->
<section class="page-hero">
    <div class="hero-background" style="background-image: url('{{ $portfolio->featured_image }}')">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">{{ $portfolio->title }}</h1>
                    @if($portfolio->category)
                        <p class="hero-subtitle">{{ $portfolio->category->title }}</p>
                    @endif
                    <div class="hero-stats">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-images"></i> {{ $portfolio->images->count() }} Imagens
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Details Section -->
<section class="portfolio-details-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Portfolio Images Gallery -->
                @if($portfolio->images && $portfolio->images->count() > 0)
                    <div class="portfolio-gallery mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="section-title mb-0">Galeria de Imagens</h3>
                            <div class="gallery-controls">
                                <span class="badge bg-primary">{{ $portfolio->images->count() }} imagens</span>
                                <button class="btn btn-outline-primary btn-sm ms-2" id="fullscreenBtn">
                                    <i class="fas fa-expand"></i> Tela Cheia
                                </button>
                            </div>
                        </div>
                        
                        <!-- Gallery Grid -->
                        <div class="row g-3" id="galleryGrid">
                            @foreach($portfolio->images as $index => $image)
                                <div class="col-6 col-lg-4 gallery-item-wrapper" data-index="{{ $index }}">
                                    <a href="{{ asset('storage/' . $image->image_path) }}" 
                                       data-lightbox="portfolio-{{ $portfolio->id }}" 
                                       data-title="{{ $portfolio->title }} - Imagem {{ $index + 1 }} de {{ $portfolio->images->count() }}"
                                       class="gallery-link">
                                        <div class="gallery-item">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                 alt="{{ $portfolio->title }} - Imagem {{ $index + 1 }}" 
                                                 class="gallery-image"
                                                 loading="lazy">
                                            <div class="gallery-overlay">
                                                <i class="fas fa-search-plus"></i>
                                                <span class="image-counter">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Gallery Navigation -->
                        <div class="gallery-navigation mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted me-3">Navegação:</span>
                                        <button class="btn btn-outline-secondary btn-sm me-2" id="prevImage" disabled>
                                            <i class="fas fa-chevron-left"></i> Anterior
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" id="nextImage">
                                            Próxima <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="gallery-info">
                                        <span class="text-muted">Clique nas imagens para ampliar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Nenhuma imagem disponível para este portfólio.
                    </div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <!-- Portfolio Information -->
                <div class="portfolio-info">
                    <div class="card sticky-top" style="top: 100px;">
                        <div class="card-body">
                            <h4 class="card-title">Informações do Evento</h4>
                            
                            @if($portfolio->category)
                                <div class="info-item mb-3">
                                    <strong>Categoria:</strong>
                                    <span class="badge bg-primary">{{ $portfolio->category->title }}</span>
                                </div>
                            @endif
                            
                            @if($portfolio->description)
                                <div class="info-item mb-3">
                                    <strong>Descrição:</strong>
                                    <p class="mt-2">{{ $portfolio->description }}</p>
                                </div>
                            @endif
                            
                            <div class="info-item mb-3">
                                <strong>Total de Imagens:</strong>
                                <span class="badge bg-info">{{ $portfolio->images->count() }}</span>
                            </div>
                            
                            <div class="info-item mb-3">
                                <strong>Data de Criação:</strong>
                                <span>{{ $portfolio->created_at->format('d/m/Y') }}</span>
                            </div>
                            
                            @if($portfolio->sort_order)
                                <div class="info-item mb-3">
                                    <strong>Ordem de Exibição:</strong>
                                    <span>{{ $portfolio->sort_order }}</span>
                                </div>
                            @endif
                            
                            <hr>
                            
                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('site.categories.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left"></i> Voltar aos Eventos
                                </a>
                                @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getSettings['cellphone']) }}" target="_Blank" class="btn btn-primary">
                                    <i class="fab fa-whatsapp"></i>
                                    Agendar Visita
                                </a>
                                @endif
                                <button class="btn btn-outline-secondary" id="shareBtn">
                                    <i class="fas fa-share"></i> Compartilhar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Portfolios Section -->
<section class="related-portfolios-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="section-title">Outros Eventos</h3>
            <p class="section-subtitle">Confira outros eventos realizados em nosso espaço</p>
        </div>
        
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{ route('site.categories.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-images"></i> Ver Todos os Eventos
                </a>
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
            anchor.addEventListener('click', function (e) {
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

        // Gallery Navigation
        let currentImageIndex = 0;
        const totalImages = {{ $portfolio->images->count() }};
        const prevBtn = document.getElementById('prevImage');
        const nextBtn = document.getElementById('nextImage');

        function updateNavigationButtons() {
            prevBtn.disabled = currentImageIndex === 0;
            nextBtn.disabled = currentImageIndex === totalImages - 1;
        }

        prevBtn.addEventListener('click', function() {
            if (currentImageIndex > 0) {
                currentImageIndex--;
                const targetImage = document.querySelector(`[data-index="${currentImageIndex}"]`);
                if (targetImage) {
                    targetImage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                updateNavigationButtons();
            }
        });

        nextBtn.addEventListener('click', function() {
            if (currentImageIndex < totalImages - 1) {
                currentImageIndex++;
                const targetImage = document.querySelector(`[data-index="${currentImageIndex}"]`);
                if (targetImage) {
                    targetImage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                updateNavigationButtons();
            }
        });

        // Fullscreen Button
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        fullscreenBtn.addEventListener('click', function() {
            const galleryGrid = document.getElementById('galleryGrid');
            if (galleryGrid.requestFullscreen) {
                galleryGrid.requestFullscreen();
            } else if (galleryGrid.webkitRequestFullscreen) {
                galleryGrid.webkitRequestFullscreen();
            } else if (galleryGrid.msRequestFullscreen) {
                galleryGrid.msRequestFullscreen();
            }
        });

        // Share Button
        const shareBtn = document.getElementById('shareBtn');
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $portfolio->title }} - Espaço 637',
                    text: 'Confira este evento incrível no Espaço 637!',
                    url: window.location.href
                });
            } else {
                // Fallback: copy URL to clipboard
                navigator.clipboard.writeText(window.location.href).then(function() {
                    alert('Link copiado para a área de transferência!');
                });
            }
        });

        // Lazy loading for images
        const images = document.querySelectorAll('.gallery-image[loading="lazy"]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.src; // Trigger load
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && !prevBtn.disabled) {
                prevBtn.click();
            } else if (e.key === 'ArrowRight' && !nextBtn.disabled) {
                nextBtn.click();
            }
        });
    });
</script>

<style>
    .gallery-item-wrapper {
        transition: transform 0.3s ease;
    }
    
    .gallery-item-wrapper:hover {
        transform: scale(1.02);
    }
    
    .gallery-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 8px;
        color: white;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    
    .image-counter {
        font-size: 0.8rem;
        margin-top: 5px;
    }
    
    .hero-stats {
        margin-top: 1rem;
    }
    
    .gallery-controls {
        display: flex;
        align-items: center;
    }
    
    .sticky-top {
        z-index: 1020;
    }
    
    @media (max-width: 768px) {
        .gallery-image {
            height: 150px;
        }
        
        .gallery-controls {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>
@endsection