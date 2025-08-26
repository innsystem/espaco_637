@extends('site.base')

@section('title', 'Sobre - Espaço 637')

@section('content')
<section class="about-section space-top space-bottom">
    <div class="container">
        <!-- Hero Section -->
        <div class="row justify-content-center align-items-center mb-5">
            <div class="col-lg-6">
                <div class="about-content">
                    <h1 class="about-title">Sobre o Espaço 637</h1>
                    <p class="about-subtitle">Onde sonhos se tornam realidade</p>
                    <p class="about-description">Tudo começou com a paixão pela cervejaria artesanal, que de um hobby caseiro foi convergindo para uma estrutura profissional e aplicada a qualidade e ao bem estar dos amigos e clientes.</p>
                    
                    <p class="about-description">Em meio a 8 mil metros quadrados, nasceu um ambiente único, inspirado no estilo de rancho americano, com cavalos, piquetes e a atmosfera rústica do campo — mas sem abrir mão do conforto e da tecnologia moderna.</p>
                    
                    <p class="about-description">Com o tempo, percebemos que esse espaço tinha potencial para muito mais do que apenas ser um ponto de encontro. Assim nasceu o Espaço 637, um local versátil e encantador, ideal para receber casamentos, aniversários, eventos corporativos e celebrações em geral.</p>
                    
                    <div class="about-stats">
                        <div class="stat-item">
                            <span class="stat-number">200+</span>
                            <span class="stat-label">Eventos Realizados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8 mil</span>
                            <span class="stat-label">Metros Quadrados</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">500</span>
                            <span class="stat-label">Capacidade Máxima</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-image-wrapper">
                    <img src="{{ asset('galerias/espaco637/ranch-exterior-1.jpg') }}" alt="Espaço 637 - Rancho Exterior" class="about-image">
                </div>
            </div>
        </div>

        <!-- Nossa História -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title text-center">Nossa História</h2>
                <div class="timeline-container">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h4>Cervejaria Artesanal</h4>
                                <p>De um hobby caseiro evoluiu para uma estrutura profissional aplicada à qualidade e ao bem estar dos amigos e clientes.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h4>Rancho Americano</h4>
                                <p>Em meio a 8 mil metros quadrados, nasceu um ambiente único inspirado no estilo de rancho americano, com cavalos, piquetes e atmosfera rústica.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h4>Espaço 637</h4>
                                <p>Percebemos que esse espaço tinha potencial para muito mais. Assim nasceu o Espaço 637, ideal para receber grandes celebrações.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nossa Filosofia -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <div class="about-image-wrapper">
                    <img src="{{ asset('galerias/espaco637/bar-area.jpg') }}" alt="Área do Bar - Espaço 637" class="about-image">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="section-title">Nossa Filosofia</h2>
                    <p class="about-description">Aqui, unimos a autenticidade do campo com a estrutura necessária para grandes eventos, oferecendo um cenário inesquecível para os momentos mais especiais da sua vida.</p>
                    
                    <div class="philosophy-points">
                        @foreach($philosophyPoints as $point)
                        <div class="philosophy-point">
                            <i class="{{ $point->icon }}"></i>
                            <div>
                                <h4>{{ $point->title }}</h4>
                                <p>{{ $point->description }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="row">
            <div class="col-12">
                <div class="cta-section">
                    <h2>Pronto para realizar seu evento dos sonhos?</h2>
                    <p>Entre em contato conosco e transforme sua celebração em uma memória inesquecível</p>
                    @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getSettings['cellphone']) }}" target="_Blank" class="cta-button">
                        <i class="fab fa-whatsapp"></i>
                        Agendar Visita
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

