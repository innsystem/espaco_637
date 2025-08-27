@extends('site.base')

@section('title', 'Espaço 637 - Eventos Inesquecíveis')

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero-section">
    <div class="hero-carousel">
        @if($sliders && $sliders->count() > 0)
        @foreach($sliders as $index => $slider)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $slider->image) }}')">
            <div class="hero-overlay"></div>
            <div class="hero-slide-content">
                @if($slider->title)
                <h2 class="hero-slide-title">{{ $slider->title }}</h2>
                @endif
                @if($slider->subtitle)
                <p class="hero-slide-subtitle">{{ $slider->subtitle }}</p>
                @endif
                <div class="hero-slide-buttons">
                    <a href="#about" class="btn btn-primary btn-lg me-3">Conheça Nossa História</a>
                    <a href="#events" class="btn btn-outline-light btn-lg">Ver Galeria</a>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <div class="hero-controls">
        <button class="hero-control prev" id="prevSlide">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-control next" id="nextSlide">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    @if($sliders && $sliders->count() > 1)
    <div class="hero-indicators">
        @foreach($sliders as $index => $slider)
        <span class="indicator {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
        @endforeach
    </div>
    @else
    <div class="hero-indicators">
        <span class="indicator active" data-slide="0"></span>
        <span class="indicator" data-slide="1"></span>
        <span class="indicator" data-slide="2"></span>
    </div>
    @endif
</section>

@if(isset($portfoliosByCategory) && $portfoliosByCategory->count() > 0)
<!-- Events Gallery Section -->
<section id="events" class="events-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Nossos Eventos</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Cada celebração é única, assim como nosso espaço</p>
        </div>

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
            @foreach($portfolios as $portfolio)
            @if($portfolio->images && $portfolio->images->count() > 0)
            <div class="portfolio-preview mb-4">
                <div class="row g-3">
                    @foreach($portfolio->images->take(4) as $image)
                    <div class="col-6 col-lg-3">
                        <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="portfolio-{{ $categoryId }}" data-title="{{ $portfolio->title }}">
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $portfolio->title }}" class="gallery-image">
                                <div class="gallery-overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Botão para ver o evento completo
                <div class="text-center mt-3">
                    <a href="{{ route('site.portfolios.show', ['slug' => $portfolio->slug]) }}" class="btn btn-theme btn-sm">
                        <i class="fas fa-eye"></i> Ver Evento
                    </a>
                </div> -->
            </div>
            @endif
            @endforeach
        </div>
        @endif
        @endforeach

        <div class="text-center mt-5">
            <p class="mb-3">Quer ver mais? Visite nosso espaço e descubra todas as possibilidades</p>
            @if($statistics->where('id', 1)->first())
            <div class="success-badge">
                <span>{{ $statistics->where('id', 1)->first()->value }} {{ $statistics->where('id', 1)->first()->title }} com sucesso</span>
            </div>
            @endif

            @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
            <div class="mt-4">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getSettings['cellphone']) }}" target="_Blank" class="btn btn-primary btn-lg">
                    <i class="fab fa-whatsapp"></i>
                    Agendar Visita
                </a>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Services Section -->
<section id="services" class="services-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="service-header-image">
                    <img src="{{ asset('galerias/espaco637/08.jpg') }}" alt="Detalhes da Mesa" class="service-image">
                    <div class="service-image-overlay">
                        <h2 class="service-image-title">O que Oferecemos</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-header-image">
                    <img src="{{ asset('galerias/espaco637/04.jpg') }}" alt="Pavilhão à Noite" class="service-image">
                    <div class="service-image-overlay">
                        <div class="service-image-content">
                            <div class="service-image-subtitle">Estrutura</div>
                            <div class="service-image-text">Completa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($serviceFeatures as $feature)
            <div class="col-6 col-md-3">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="{{ $feature->icon }}"></i>
                    </div>
                    <h3 class="service-title">{{ $feature->title }}</h3>
                    <p class="service-description">{{ $feature->description }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <div class="service-cta">
                <div class="pulse-dot"></div>
                <span>Tudo isso em um só lugar</span>
                <div class="pulse-dot"></div>
            </div>
        </div>
    </div>
</section>

@if(isset($products) && $products->count() > 0)
<!-- Products Section -->
<section id="products" class="products-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Nossas Cervejas Artesanais</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Descubra nossa seleção de cervejas artesanais exclusivas</p>
        </div>

        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('tpl_site/img/placeholder-beer.svg') }}" alt="{{ $product->title }}" class="product-img">
                    </div>
                    <div class="product-info">
                        <h4 class="product-title">{{ $product->title }}</h4>
                        <p class="product-description">{{ $product->description }}</p>
                        @if($product->price > 0)
                        <div class="product-price">{{ $product->formatted_price }}</div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('site.categories.index') }}" class="btn btn-theme btn-lg">
                <i class="fas fa-beer"></i> Ver Todas as Cervejas
            </a>
        </div>
    </div>
</section>
@endif

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            @foreach($statistics as $statistic)
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number" data-count="{{ $statistic->value }}">0</div>
                    <div class="stat-label">{{ $statistic->title }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-images">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="about-image-wrapper">
                                <img src="{{ asset('galerias/espaco637/01.jpg') }}" alt="Exterior do Rancho" class="about-image">
                            </div>
                            <div class="about-image-wrapper mt-4">
                                <img src="{{ asset('galerias/espaco637/06.jpg') }}" alt="Exterior do Rancho" class="about-image">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="about-image-wrapper mt-4">
                                <img src="{{ asset('galerias/espaco637/05.jpg') }}" alt="Área do Bar" class="about-image">
                            </div>
                            <div class="about-image-wrapper mt-4">
                                <img src="{{ asset('galerias/espaco637/02.jpg') }}" alt="Área do Bar" class="about-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="section-title">Nossa História</h2>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <p><strong>Cervejaria artesanal</strong> caseira evoluiu para estrutura profissional</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <p><strong>Rancho americano</strong> com cavalos, piquetes e atmosfera rústica</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <p><strong>Espaço 637</strong> nasceu para receber grandes celebrações</p>
                        </div>
                    </div>

                    <div class="philosophy-points mt-4">
                        @foreach($philosophyPoints as $point)
                        <div class="philosophy-item">
                            <div class="philosophy-icon">
                                <i class="{{ $point->icon }}"></i>
                            </div>
                            <div class="philosophy-content">
                                <h4>{{ $point->title }}</h4>
                                <p>{{ $point->description }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-content">
                    <h2 class="section-title">Entre em Contato</h2>
                    <p class="contact-subtitle">Venha conhecer nosso espaço e descubra como podemos tornar seu evento inesquecível</p>

                    <div class="contact-info">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Endereço</h4>
                                <p>{{ $getSettings['address'] ?? 'Espaço 637 - Zona Rural' }}</p>
                            </div>
                        </div>
                        @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Telefone</h4>
                                <p>{{ $getSettings['cellphone'] ?? '(11) 99999-9999' }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Email</h4>
                                <p>{{ $getSettings['site_email'] ?? 'contato@espaco637.com.br' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-cta">
                        @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                        <a class="btn btn-primary btn-lg" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getSettings['cellphone']) }}" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            Agendar Visita
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="faq-section">
                    <h3>Perguntas Frequentes</h3>
                    <div class="faq-list">
                        @foreach($faqs as $faq)
                        <div class="faq-item">
                            <div class="faq-question">
                                <h4>{{ $faq->question }}</h4>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>{{ $faq->answer }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
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
        // Hero Carousel
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.indicator');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));

            slides[index].classList.add('active');
            indicators[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        // Auto advance slides apenas se houver mais de 1 slide
        if (slides.length > 1) {
            setInterval(nextSlide, 5000);
        }

        // Manual controls
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);

        // Indicators
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

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

        // Animate stats on scroll
        const statsSection = document.querySelector('.stats-section');
        const statNumbers = document.querySelectorAll('.stat-number');

        function animateStats() {
            statNumbers.forEach(stat => {
                const target = parseInt(stat.getAttribute('data-count'));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    stat.textContent = Math.floor(current);
                }, 16);
            });
        }

        // Intersection Observer for stats animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateStats();
                    observer.unobserve(entry.target);
                }
            });
        });

        if (statsSection) {
            observer.observe(statsSection);
        }

        // FAQ Accordion
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                const answer = faqItem.querySelector('.faq-answer');
                const icon = question.querySelector('i');

                // Close other FAQs
                document.querySelectorAll('.faq-item').forEach(item => {
                    if (item !== faqItem) {
                        item.classList.remove('active');
                        item.querySelector('.faq-answer').style.maxHeight = '0';
                        item.querySelector('.faq-question i').classList.remove('fa-chevron-up');
                        item.querySelector('.faq-question i').classList.add('fa-chevron-down');
                    }
                });

                // Toggle current FAQ
                faqItem.classList.toggle('active');
                if (faqItem.classList.contains('active')) {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    answer.style.maxHeight = '0';
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>

<style>
    /* Estilos para o conteúdo dos sliders */
    .hero-slide-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        z-index: 10;
        width: 90%;
        max-width: 600px;
    }

    .hero-slide-title {
        font-family: 'Playfair Display', serif;
        font-size: 4rem;
        font-weight: 900;
        margin-bottom: 1.5rem;
        text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .hero-slide-subtitle {
        font-size: 1.5rem;
        font-weight: 300;
        margin-bottom: 3rem;
        opacity: 0.9;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-slide-content .btn,
    .hero-slide-buttons .btn {
        font-size: 1.1rem;
        padding: 12px 30px;
        border-radius: 50px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        margin: 0 5px;
    }

    .hero-slide-content .btn:hover,
    .hero-slide-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .hero-slide-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    /* Estilos para os botões dos portfólios */
    .btn-theme {
        background: var(--ranch-green);
        border-color: var(--ranch-green);
        color: white;
        font-weight: 500;
        transition: var(--transition-smooth);
    }

    .btn-theme:hover {
        background: var(--ranch-green-light);
        border-color: var(--ranch-green-light);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-glow);
    }


    /* Responsividade para o conteúdo dos sliders */
    @media (max-width: 768px) {
        .hero-slide-title {
            font-size: 2.5rem;
        }

        .hero-slide-subtitle {
            font-size: 1.2rem;
        }

        .hero-slide-content .btn,
        .hero-slide-buttons .btn {
            font-size: 1rem;
            padding: 10px 25px;
        }

        .hero-slide-buttons {
            flex-direction: column;
            align-items: center;
        }


    }

    @media (max-width: 576px) {
        .hero-slide-title {
            font-size: 2rem;
        }

        .hero-slide-subtitle {
            font-size: 1rem;
        }

        .hero-slide-content .btn,
        .hero-slide-buttons .btn {
            font-size: 0.9rem;
            padding: 8px 20px;
        }

        .hero-slide-buttons {
            gap: 10px;
        }
    }
</style>
@endsection