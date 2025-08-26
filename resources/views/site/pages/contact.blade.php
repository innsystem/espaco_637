@extends('site.base')

@section('title', 'Contato - Espaço 637')

@section('content')
<section class="contact-page-section space-top space-bottom">
    <div class="container">
        <!-- Hero Section -->
        <div class="row justify-content-center align-items-center mb-5">
            <div class="col-10">
                <div class="about-content text-center">
                    <h1 class="about-title">Entre em Contato</h1>
                    <p class="about-subtitle">Vamos conversar sobre seu evento especial</p>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <div class="contact-info-section">
                    <h2 class="section-title">Informações de Contato</h2>
                    <p class="mb-4">Estamos aqui para ajudar você a realizar o evento dos seus sonhos. Entre em contato conosco e descubra todas as possibilidades que o Espaço 637 oferece.</p>
                    
                    <div class="contact-info-grid">
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Endereço</h4>
                                <p>{{ $getSettings['address'] ?? 'Rodovia Anhanguera, Km 637, Ribeirão Preto, SP' }}</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Telefone</h4>
                                <p>{{ $getSettings['telephone'] ?? '(16) 4002-8922' }}</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="contact-details">
                                <h4>WhatsApp</h4>
                                <p>{{ $getSettings['cellphone'] ?? '(16) 99999-9999' }}</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h4>E-mail</h4>
                                <p>{{ $getSettings['site_email'] ?? 'contato@espaco637.com.br' }}</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Horário de Atendimento</h4>
                                <p>{{ $getSettings['hour_open'] ?? 'Segunda a Sexta: 9h às 18h<br>Sábado: 9h às 16h<br>Domingo: Apenas eventos' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contact-image-section">
                    <img src="{{ asset('galerias/espaco637/pavilion-night.jpg') }}" alt="Espaço 637 - Pavilhão à Noite" class="img-fluid rounded">
                    <div class="contact-overlay-text">
                        <h3>Agende sua Visita</h3>
                        <p>Venha conhecer pessoalmente este espaço único</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Contact -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="quick-contact-section text-center">
                    <h2 class="section-title">Fale Conosco Agora</h2>
                    <p class="mb-4">Escolha a forma mais conveniente para você entrar em contato</p>
                    
                    <div class="quick-contact-buttons">
                        @if(isset($getSettings['telephone']) && $getSettings['telephone'] != '')
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $getSettings['telephone']) }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-phone me-2"></i>
                            Ligar Agora
                        </a>
                        @endif
                        
                        @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $getSettings['cellphone']) }}" class="btn btn-success btn-lg me-3" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>
                            Enviar WhatsApp
                        </a>
                        @endif
                        
                        @if(isset($getSettings['site_email']) && $getSettings['site_email'] != '')
                        <a href="mailto:{{ $getSettings['site_email'] }}" class="btn btn-info btn-lg">
                            <i class="fas fa-envelope me-2"></i>
                            Enviar E-mail
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Map -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="location-section">
                    <h2 class="section-title text-center mb-4">Nossa Localização</h2>
                    <div class="location-info">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="location-details">
                                    <h4>Como Chegar</h4>
                                    <p><strong>Rodovia Anhanguera, Km 637</strong></p>
                                    <p>Localizado estrategicamente na Rodovia Anhanguera, o Espaço 637 oferece fácil acesso tanto para quem vem de Ribeirão Preto quanto de outras cidades da região.</p>
                                    
                                    <div class="location-features">
                                        <div class="feature-item">
                                            <i class="fas fa-car"></i>
                                            <span>Amplo estacionamento gratuito</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-sign"></i>
                                            <span>Sinalização clara na rodovia</span>
                                        </div>
                                        <div class="feature-item">
                                            <i class="fas fa-map"></i>
                                            <span>Fácil localização no GPS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="map-placeholder">
                                    <div class="map-content">
                                        <i class="fas fa-map-marked-alt"></i>
                                        <h4>Mapa Interativo</h4>
                                        <p>Clique para abrir no Google Maps</p>
                                        <a href="https://maps.google.com/?q=Rodovia+Anhanguera+Km+637+Ribeirão+Preto+SP" target="_blank" class="btn btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-2"></i>
                                            Abrir no Google Maps
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row">
            <div class="col-12">
                <div class="faq-section">
                    <h2 class="section-title text-center mb-4">Perguntas Frequentes</h2>
                    <div class="faq-grid">
                        @foreach($faqs as $faq)
                        <div class="faq-item">
                            <h4>{{ $faq->question }}</h4>
                            <p>{{ $faq->answer }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
