@extends('site.base')

@section('title', 'Serviços - Espaço 637')

@section('content')
<section class="services-detail-section space-top space-bottom">
    <div class="container">
        <!-- Hero Section -->
        <div class="row justify-content-center align-items-center mb-5">
            <div class="col-10">
                <div class="about-content text-center">
                    <h1 class="about-title">Nossos Serviços</h1>
                    <p class="about-subtitle">Estrutura completa para seu evento especial</p>
                </div>
            </div>
        </div>

        <!-- Services Overview -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="section-title">O que Oferecemos</h2>
                    <p class="about-description">No Espaço 637, oferecemos uma estrutura completa e profissional para realizar seu evento dos sonhos. Nossa equipe especializada cuida de cada detalhe para garantir que sua celebração seja perfeita.</p>
                    <p class="about-description">Com 8 mil metros quadrados de área, inspirados no estilo rancho americano, proporcionamos um ambiente único que combina autenticidade rústica com conforto e tecnologia moderna.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image-wrapper">
                    <img src="{{ asset('galerias/espaco637/pavilion-night.jpg') }}" alt="Pavilhão à Noite - Espaço 637" class="img-fluid about-image">
                </div>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title text-center mb-4">Nossos Diferenciais</h2>
                <div class="services-grid">
                    @foreach($serviceFeatures as $feature)
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="{{ $feature->icon }}"></i>
                        </div>
                        <h3>{{ $feature->title }}</h3>
                        <p>{{ $feature->description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Event Types -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title text-center mb-4">Tipos de Eventos</h2>
                <div class="event-types-grid">
                    <div class="event-type-card">
                        <div class="event-type-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Casamentos</h3>
                        <p>Casamentos românticos e elegantes com capacidade para até 200 convidados. Inclui cerimônia e recepção.</p>
                        <ul>
                            <li>Decoração completa</li>
                            <li>Buffet personalizado</li>
                            <li>Música ao vivo ou DJ</li>
                            <li>Fotografia profissional</li>
                        </ul>
                    </div>

                    <div class="event-type-card">
                        <div class="event-type-icon">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <h3>Aniversários</h3>
                        <p>Celebrações de aniversário descontraídas e divertidas para todas as idades.</p>
                        <ul>
                            <li>Ambiente festivo</li>
                            <li>Atividades recreativas</li>
                            <li>Passeio a cavalo opcional</li>
                            <li>Degustação de cervejas artesanais</li>
                        </ul>
                    </div>

                    <div class="event-type-card">
                        <div class="event-type-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3>Eventos Corporativos</h3>
                        <p>Eventos empresariais com estrutura profissional e ambiente diferenciado.</p>
                        <ul>
                            <li>Estrutura tecnológica completa</li>
                            <li>Coffee break premium</li>
                            <li>Atividades de team building</li>
                            <li>Suporte técnico especializado</li>
                        </ul>
                    </div>

                    <div class="event-type-card">
                        <div class="event-type-icon">
                            <i class="fas fa-beer"></i>
                        </div>
                        <h3>Cervejaria Artesanal</h3>
                        <p>Degustação de cervejas artesanais produzidas com qualidade e paixão.</p>
                        <ul>
                            <li>Kit com 6 cervejas especiais</li>
                            <li>IPA, Pilsen, Stout, Weiss</li>
                            <li>Pale Ale e Lager</li>
                            <li>Experiência gastronômica única</li>
                        </ul>
                    </div>

                    <div class="event-type-card">
                        <div class="event-type-icon">
                            <i class="fas fa-horse"></i>
                        </div>
                        <h3>Experiências Rurais</h3>
                        <p>Vivências no campo com cavalos, piquetes e atmosfera rústica.</p>
                        <ul>
                            <li>Passeio guiado a cavalo</li>
                            <li>Almoço rústico no campo</li>
                            <li>Fotografias da experiência</li>
                            <li>Duração: 4 horas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="row">
            <div class="col-12">
                <div class="cta-section">
                    <h2>Pronto para realizar seu evento especial?</h2>
                    <p>Entre em contato conosco e descubra todas as possibilidades para sua celebração</p>
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