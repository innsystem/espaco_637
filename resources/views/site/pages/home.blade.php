@extends('site.base')

@section('title', 'Lâminas Naturais e Compostas de Alta Qualidade')

@section('content')
<div class="th-hero-wrapper hero-3 hero-4 slider-area" id="hero">
    <div class="swiper th-slider" id="heroSlide4" data-slider-options='{"effect":"fade","autoHeight":true}'>
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
            <div class="swiper-slide"
                data-bg-src="@webpUrl($slider->image)"
                data-bg-srcset="@webpSrcset($slider->image)"
                data-bg-sizes="(max-width: 768px) 768px, (max-width: 1600px) 1600px, 1920px">
                <div class="hero-inner">
                    <div class="container">
                        <div class="hero-style4">
                            <div class="hero-star-rating" data-ani="slideinup" data-ani-delay="0.4s">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.6s">{{ $slider->title }}</h1>
                            @if($slider->subtitle)
                            <p class="hero-text" data-ani="slideinup" data-ani-delay="0.7s">{{ $slider->subtitle }}</p>
                            @endif
                            @if($slider->href)
                            <div class="btn-group mt-1" data-ani="slideinup" data-ani-delay="0.8s">
                                <a href="{{ $slider->href }}" class="th-btn2 th-icon" target="{{ $slider->target }}">SAIBA MAIS<i class="fas fa-arrow-right"></i></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <button class="slider-arrow slider-prev slider-prev-bg"
            style="background-image: url({{ asset('/storage/sliders/slider_1.png') }});">
            <span class="arrow">
                <img src="{{ asset('tpl_site/img/icon/hero-arrow-left.svg') }}" alt="">
            </span>
        </button>
        <button class="slider-arrow slider-next slider-next-bg"
            style="background-image: url({{ asset('/storage/sliders/slider_2.png') }});">
            <span class="arrow">
                <img src="{{ asset('tpl_site/img/icon/hero-arrow-right.svg') }}" alt="">
            </span>
        </button>
    </div>
</div>

<div class=" overflow-hidden space" id="about-sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <div class="about-content-wrap">
                    <div class="title-area mb-45">
                        <h2 class="sec-title">Bem-Vindo ao Espaço 637: <br> - Lâminas Importadas <br> - Selecionadas Pessoalmente <br> - Excelência em Prensagem</h2>
                        <span class="sub-title2 style1">SOBRE NÓS</span>
                        <p class="sec-text">O Espaço 637 é uma empresa especializada na comercialização da mais alta qualidade de lâminas de madeira natural. Nossas lâminas são cuidadosamente selecionadas para garantir não apenas beleza, mas também durabilidade e praticidade. Com um forte compromisso em facilitar o dia a dia de nossos clientes e parceiros estamos sempre prontos para orientar e auxiliá-los na escolha dos produtos mais adequados. Acreditamos que, ao oferecer o melhor em lâminas, contribuímos para a realização de projetos únicos e inspiradores.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <img src="{{ asset('storage/abouts/image_544-777.webp?2') }}" class="img-fluid rounded" alt="imagem de design">
            </div>
        </div>

        <div class="row align-items-center mt-4 mt-md-0">
            <div class="col-12 col-xxl-8">
                <div class="slider-wrap">
                    <div class="swiper th-slider about-room-slider" id="aboutroomSlider1"
                        data-slider-options='{"slidesPerView":"1", "effect": "fade", "aautoHeight": "true"}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="about-room-card">
                                    <div class="box-img global-img">
                                        <img src="{{ asset('/storage/abouts/slide_portfolio.webp') }}" alt="imagem de lâmina">
                                    </div>
                                    <div class="box-content">
                                        <div class="box-icon"><img
                                                src="{{ asset('tpl_site/img/icon/feature_card_3.svg') }}" alt="ícone de característica">
                                        </div>
                                        <h3 class="box-title"><a href="room.html">Portfólio Completo de Lâminas</a></h3>
                                        <p class="box-text">Descubra nossa vasta gama de lâminas naturais e compostas, cuidadosamente selecionadas para a máxima beleza e durabilidade em seus projetos.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="about-room-card">
                                    <div class="box-img global-img">
                                        <img src="{{ asset('/storage/abouts/slide_prensa.webp?1') }}" alt="imagem de serviço">
                                    </div>
                                    <div class="box-content">
                                        <div class="box-icon"><img
                                                src="{{ asset('tpl_site/img/icon/feature_card_2.svg') }}" alt="ícone de serviço">
                                        </div>
                                        <h3 class="box-title"><a href="room.html">Prensagem Térmica de Alta Precisão</a></h3>
                                        <p class="box-text">Nosso serviço de prensagem térmica garante acabamentos perfeitos e máxima adesão, ideal para marcenaria profissional e projetos sob medida.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="about-room-card">
                                    <div class="box-img global-img">
                                        <img src="{{ asset('/storage/abouts/slide_compromisso.webp?1') }}" alt="imagem de segurança">
                                    </div>
                                    <div class="box-content">
                                        <div class="box-icon"><img
                                                src="{{ asset('tpl_site/img/icon/feature_card_1.svg') }}" alt="ícone de qualidade">
                                        </div>
                                        <h3 class="box-title"><a href="room.html">Compromisso com a Qualidade</a></h3>
                                        <p class="box-text">No Espaço 637, cada detalhe é importante. Garantimos a qualidade superior de nossas lâminas e a excelência em todos os nossos processos.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="slider-pagination style2" data-slider-id="#aboutroomSlider1"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xxl-4 mt-4 mt-xxl-0">
                <div class="text-center">
                    <a href="https://wa.me/@formatPhone($getSettings['cellphone'])" class="th-btn2 th-icon" target="_blank">ENTRE EM CONTATO</a>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="offer-area5 position-relative overflow-hidden space-bottom overflow-hidden" id="offer-sec">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="title-area">
                    <span class="sub-title2">LÂMINAS</span>
                    <h2 class="sec-title text-white">Naturais</h2>
                </div>
            </div>
        </div>
        <div class="slider-area">
            <div class="laminas-container">
                <div class="laminas-scroll">
                    @forelse($products as $product)
                    <a href="{{ route('site.product.detail', $product->slug) }}" class="lamina-item">
                        <div class="lamina-img">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                        </div>
                        <div class="lamina-title">
                            <h3>{{ $product->title }}</h3>
                        </div>
                    </a>
                    @empty
                    <p>Nenhum produto disponível no momento.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>


<section class="overflow-hidden space-bottom overflow-hidden" id="service-sec">
    <div class="container">
        <div class="row gy-60">
            <div class="col-12 service-card-wrap">
                <div class="service-card style3">
                    <div class="box-img">
                        <img src="{{ asset('/storage/services/image_970-450.webp?1') }}" alt="Serviço de Prensagem">
                    </div>
                    <div class="box-content">
                        <h6 class="box-subtitle">Alta Precisão e Produtividade</h6>
                        <h3 class="box-title"><a href="service-details.html">Prensagem Térmica Profissional</a></h3>
                        <p class="box-text">Com mais de 30 anos de experiência com lâminas naturais e compostas, nossa empresa oferece um serviço de prensagem térmica altamente técnico e confiável, desenvolvido para atender as exigências da marcenaria profissional.</p>
                        <a href="{{ route('site.services') }}" class="th-btn2 style2 th-icon">SAIBA MAIS</a>
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
        const laminasScroll = document.querySelector('.laminas-scroll');

        if (!laminasScroll) return;

        // Variáveis para controle de touch/drag
        let isDown = false;
        let startX;
        let scrollLeft;
        let hasScrolled = false;

        // Configurar eventos de mouse para desktop (drag to scroll)
        laminasScroll.addEventListener('mousedown', (e) => {
            // Não iniciar drag se clicou em um item
            if (e.target.closest('.lamina-item')) {
                return;
            }

            isDown = true;
            hasScrolled = false;
            laminasScroll.style.cursor = 'grabbing';
            startX = e.pageX - laminasScroll.offsetLeft;
            scrollLeft = laminasScroll.scrollLeft;

            // Prevenir seleção de texto
            e.preventDefault();
        });

        laminasScroll.addEventListener('mouseleave', () => {
            isDown = false;
            laminasScroll.style.cursor = 'default';
            laminasScroll.classList.remove('is-dragging');
        });

        laminasScroll.addEventListener('mouseup', () => {
            isDown = false;
            laminasScroll.style.cursor = 'default';

            // Remover classe is-dragging após um pequeno delay
            setTimeout(() => {
                laminasScroll.classList.remove('is-dragging');
            }, 100);
        });

        laminasScroll.addEventListener('mousemove', (e) => {
            if (!isDown) return;

            e.preventDefault();
            const x = e.pageX - laminasScroll.offsetLeft;
            const walk = (x - startX) * 1.5; // Velocidade do scroll reduzida

            // Só considerar como scroll se moveu significativamente
            if (Math.abs(walk) > 5) {
                hasScrolled = true;
                laminasScroll.classList.add('is-dragging');
                laminasScroll.scrollLeft = scrollLeft - walk;
            }
        });

        // Configurar cursor para indicar que é arrastável apenas nos espaços vazios
        laminasScroll.style.cursor = 'default';

        // Navegação por teclado (setas esquerda/direita)
        laminasScroll.addEventListener('keydown', (e) => {
            const itemWidth = laminasScroll.querySelector('.lamina-item').offsetWidth + 20; // width + gap

            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                laminasScroll.scrollBy({
                    left: -itemWidth,
                    behavior: 'smooth'
                });
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                laminasScroll.scrollBy({
                    left: itemWidth,
                    behavior: 'smooth'
                });
            }
        });

        // Tornar focusável para navegação por teclado
        laminasScroll.setAttribute('tabindex', '0');

        // Configurar eventos de touch para mobile
        let touchStartX = 0;
        let touchEndX = 0;

        laminasScroll.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
        }, {
            passive: true
        });

        laminasScroll.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].clientX;
            handleSwipe();
        }, {
            passive: true
        });

        function handleSwipe() {
            const swipeThreshold = 50; // Distância mínima para considerar swipe
            const difference = touchStartX - touchEndX;

            if (Math.abs(difference) > swipeThreshold) {
                const itemWidth = laminasScroll.querySelector('.lamina-item').offsetWidth + 20;

                if (difference > 0) {
                    // Swipe para esquerda (próximo)
                    laminasScroll.scrollBy({
                        left: itemWidth,
                        behavior: 'smooth'
                    });
                } else {
                    // Swipe para direita (anterior)
                    laminasScroll.scrollBy({
                        left: -itemWidth,
                        behavior: 'smooth'
                    });
                }
            }
        }

        // Adicionar indicadores de início/fim do scroll (opcional)
        function updateScrollIndicators() {
            const container = document.querySelector('.laminas-container');
            const scrollWidth = laminasScroll.scrollWidth;
            const clientWidth = laminasScroll.clientWidth;
            const scrollLeft = laminasScroll.scrollLeft;

            // Remover classes existentes
            container.classList.remove('scroll-start', 'scroll-end', 'scroll-middle');

            if (scrollLeft <= 0) {
                container.classList.add('scroll-start');
            } else if (scrollLeft >= scrollWidth - clientWidth - 1) {
                container.classList.add('scroll-end');
            } else {
                container.classList.add('scroll-middle');
            }
        }

        // Atualizar indicadores no scroll
        laminasScroll.addEventListener('scroll', updateScrollIndicators);

        // Inicializar indicadores
        updateScrollIndicators();

        // Redimensionar handler para recalcular indicadores
        window.addEventListener('resize', () => {
            setTimeout(updateScrollIndicators, 100);
        });

        // Adicionar efeito de foco para acessibilidade
        const laminaItems = document.querySelectorAll('.lamina-item');

        laminaItems.forEach((item, index) => {
            item.setAttribute('tabindex', '0');
            item.setAttribute('role', 'button');
            item.setAttribute('aria-label', `Lâmina ${item.querySelector('h3').textContent}`);

            // Scroll para o item quando focado via teclado
            item.addEventListener('focus', () => {
                const itemRect = item.getBoundingClientRect();
                const containerRect = laminasScroll.getBoundingClientRect();

                if (itemRect.left < containerRect.left || itemRect.right > containerRect.right) {
                    item.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest',
                        inline: 'center'
                    });
                }
            });

            // Ação no Enter/Space
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    item.click();
                }
            });

            // Melhorar gestão de eventos de hover
            let hoverTimeout;

            item.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
                if (!isDown) {
                    item.style.pointerEvents = 'auto';
                }
            });

            item.addEventListener('mouseleave', () => {
                clearTimeout(hoverTimeout);
                hoverTimeout = setTimeout(() => {
                    item.style.pointerEvents = 'auto';
                }, 100);
            });
        });
    });
</script>
@endsection