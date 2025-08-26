// JavaScript for Espaço 637 Landing Page

// Wait for jQuery to be loaded
$(document).ready(function() {
    // Ensure jQuery is available
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded');
        return;
    }

    // Aplicar configurações
    if (typeof applyConfig === 'function') {
        applyConfig();
    }
    
    // Hero Carousel
    let currentSlide = 0;
    const slides = $('.hero-slide');
    const indicators = $('.indicator');
    const totalSlides = slides.length;
    
    function showSlide(index) {
        slides.removeClass('active');
        indicators.removeClass('active');
        
        slides.eq(index).addClass('active');
        indicators.eq(index).addClass('active');
        
        // Update hero title
        const titles = ['Espaço 637', 'Noites Mágicas', 'Eventos Únicos'];
        $('.hero-title-text').fadeOut(300, function() {
            $(this).text(titles[index]).fadeIn(300);
        });
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }
    
    // Auto advance slides
    let slideInterval = setInterval(nextSlide, 5000);
    
    // Manual controls
    $('#nextSlide').click(function() {
        clearInterval(slideInterval);
        nextSlide();
        slideInterval = setInterval(nextSlide, 5000);
    });
    
    $('#prevSlide').click(function() {
        clearInterval(slideInterval);
        prevSlide();
        slideInterval = setInterval(nextSlide, 5000);
    });
    
    // Indicator clicks
    indicators.click(function() {
        clearInterval(slideInterval);
        currentSlide = $(this).data('slide');
        showSlide(currentSlide);
        slideInterval = setInterval(nextSlide, 5000);
    });
    
    // Navigation scroll effect
    $(window).scroll(function() {
        const scrollTop = $(window).scrollTop();
        
        if (scrollTop > 100) {
            $('#mainNav').addClass('scrolled');
        } else {
            $('#mainNav').removeClass('scrolled');
        }
        
        // Animate elements on scroll
        $('.animate-on-scroll').each(function() {
            const $element = $(this);
            
            // Verificar se o elemento existe e tem offset antes de acessar suas propriedades
            if ($element.length > 0 && $element.offset()) {
                const elementTop = $element.offset().top;
                const elementBottom = elementTop + $element.outerHeight();
                const viewportTop = scrollTop;
                const viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $element.addClass('animated');
                }
            }
        });
    });
    
    // Smooth scrolling for navigation links
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        
        const target = $(this.getAttribute('href'));
        if (target.length > 0 && target.offset()) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800, 'easeInOutQuart');
        }
        
        // Close mobile menu
        $('.navbar-collapse').removeClass('show');
        $('.navbar-toggler').removeClass('active');
    });
    
    // Close mobile menu for all navigation links (including home links)
    $('.navbar-nav .nav-link').click(function() {
        // Add a small delay to ensure smooth transition
        setTimeout(function() {
            // Close mobile menu
            $('.navbar-collapse').removeClass('show');
            $('.navbar-toggler').removeClass('active');
        }, 100);
    });
    
    // Counter animation
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        const timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.text(Math.floor(current));
        }, 16);
    }
    
    // Trigger counter animation when stats section is visible
    let countersAnimated = false;
    
    $(window).scroll(function() {
        const statsSection = $('.stats-section');
        
        // Verificar se o elemento existe antes de tentar acessar suas propriedades
        if (statsSection.length > 0) {
            const statsTop = statsSection.offset().top;
            const statsBottom = statsTop + statsSection.outerHeight();
            const scrollTop = $(window).scrollTop();
            const viewportBottom = scrollTop + $(window).height();
            
            if (!countersAnimated && statsBottom > scrollTop && statsTop < viewportBottom) {
                $('.stat-number[data-count]').each(function() {
                    const target = parseInt($(this).data('count'));
                    animateCounter($(this), target);
                });
                countersAnimated = true;
            }
        }
    });
    
    // Gallery hover effects
    $('.gallery-item').hover(
        function() {
            $(this).find('.gallery-overlay').css('opacity', '1');
        },
        function() {
            $(this).find('.gallery-overlay').css('opacity', '0');
        }
    );
    
    // Service cards hover effects
    $('.service-card').hover(
        function() {
            $(this).find('.service-icon').addClass('animate__animated animate__pulse');
        },
        function() {
            $(this).find('.service-icon').removeClass('animate__animated animate__pulse');
        }
    );
    
    // Contact cards hover effects
    $('.contact-card').hover(
        function() {
            $(this).find('.contact-icon').addClass('animate__animated animate__bounceIn');
        },
        function() {
            $(this).find('.contact-icon').removeClass('animate__animated animate__bounceIn');
        }
    );
    
    // Add animation classes to elements
    function addAnimationClasses() {
        $('.hero-logo').addClass('animate__animated animate__fadeInDown');
        $('.hero-title').addClass('animate__animated animate__fadeInUp');
        $('.hero-subtitle').addClass('animate__animated animate__fadeInUp animate__delay-1s');
        $('.hero-buttons').addClass('animate__animated animate__fadeInUp animate__delay-2s');
        
        $('.section-title').addClass('animate-on-scroll');
        $('.event-category').addClass('animate-on-scroll');
        $('.service-card').addClass('animate-on-scroll');
        $('.contact-card').addClass('animate-on-scroll');
    }
    
    addAnimationClasses();
    
    // Lightbox configuration
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Imagem %1 de %2',
            'fadeDuration': 300,
            'imageFadeDuration': 300
        });
    }
    
    // Mobile menu improvements
    $('.navbar-toggler').click(function() {
        $(this).toggleClass('active');
    });
    
    // Close mobile menu when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('.navbar').length) {
            $('.navbar-collapse').removeClass('show');
            $('.navbar-toggler').removeClass('active');
        }
    });
    
    // Parallax effect for hero section
    $(window).scroll(function() {
        const scrolled = $(window).scrollTop();
        const heroSection = $('.hero-section');
        
        // Verificar se o elemento existe antes de tentar acessar suas propriedades
        if (heroSection.length > 0) {
            const heroHeight = heroSection.outerHeight();
            
            if (scrolled < heroHeight) {
                const parallax = scrolled * 0.5;
                heroSection.css('transform', `translateY(${parallax}px)`);
            }
        }
    });
    
    // Animate elements when they come into view
    function checkIfInView() {
        const windowHeight = $(window).height();
        const windowTopPosition = $(window).scrollTop();
        const windowBottomPosition = windowTopPosition + windowHeight;
        
        $('.animate-on-scroll').each(function() {
            const $element = $(this);
            
            // Verificar se o elemento existe e tem offset antes de acessar suas propriedades
            if ($element.length > 0 && $element.offset()) {
                const elementHeight = $element.outerHeight();
                const elementTopPosition = $element.offset().top;
                const elementBottomPosition = elementTopPosition + elementHeight;
                
                if (elementBottomPosition >= windowTopPosition && elementTopPosition <= windowBottomPosition) {
                    $element.addClass('animated');
                }
            }
        });
    }
    
    // Check on scroll
    $(window).scroll(checkIfInView);
    
    // Check on page load
    checkIfInView();
    
    // Add loading animation
    $(window).on('load', function() {
        $('body').addClass('loaded');
    });
    
    // Form validation (if forms are added later)
    $('form').submit(function(e) {
        const requiredFields = $(this).find('[required]');
        let isValid = true;
        
        requiredFields.each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            const $form = $(this);
            
            // Verificar se o formulário existe e tem offset antes de acessar suas propriedades
            if ($form.length > 0 && $form.offset()) {
                $('html, body').animate({
                    scrollTop: $form.offset().top - 100
                }, 500);
            }
        }
    });
    
    // Remove validation classes on input
    $('input, textarea').on('input', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Back to top button (optional)
    const backToTop = $('<button class="back-to-top" title="Voltar ao topo"><i class="fas fa-chevron-up"></i></button>');
    $('body').append(backToTop);
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            backToTop.fadeIn();
        } else {
            backToTop.fadeOut();
        }
    });
    
    backToTop.click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
    });
    
    // Add CSS for back to top button
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .back-to-top {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                background: var(--ranch-green);
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                display: none;
                z-index: 1000;
                transition: var(--transition-smooth);
                box-shadow: var(--shadow-glow);
            }
            .back-to-top:hover {
                background: var(--ranch-green-light);
                transform: translateY(-3px);
            }
            .back-to-top i {
                font-size: 1.2rem;
            }
        `)
        .appendTo('head');
    
    // Preloader (optional)
    const preloader = $('<div class="preloader"><div class="spinner"></div></div>');
    $('body').prepend(preloader);
    
    $(window).on('load', function() {
        preloader.fadeOut(500);
    });
    
    // Add CSS for preloader
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: var(--ranch-cream);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }
            .spinner {
                width: 50px;
                height: 50px;
                border: 3px solid var(--ranch-green);
                border-top: 3px solid transparent;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `)
        .appendTo('head');
    
    // Initialize tooltips (if Bootstrap tooltips are used)
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Add custom easing for smooth animations
    $.easing.easeInOutQuart = function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
        return -c/2 * ((t-=2)*t*t*t - 2) + b;
    };
    
    // Performance optimization: throttle scroll events
    let ticking = false;
    
    function updateOnScroll() {
        // Scroll-based animations here
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateOnScroll);
            ticking = true;
        }
    }
    
    $(window).scroll(requestTick);
    
    // Add intersection observer for better performance
    if ('IntersectionObserver' in window) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, observerOptions);
        
        $('.animate-on-scroll').each(function() {
            observer.observe(this);
        });
    }
    
    // Add touch support for mobile
    if ('ontouchstart' in window) {
        $('.gallery-item, .service-card, .contact-card').on('touchstart', function() {
            $(this).addClass('touch-active');
        }).on('touchend', function() {
            $(this).removeClass('touch-active');
        });
    }
    
    // Add CSS for touch effects
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .touch-active {
                transform: scale(0.95) !important;
            }
        `)
        .appendTo('head');
    
    console.log('Espaço 637 Landing Page initialized successfully!');
});
