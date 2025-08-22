@extends('site.base')

@section('title', 'Serviços - Prensagem Térmica Profissional - Espaço 637')

@section('content')
<section class="about-section space-top space-bottom">
    <div class="container">
        <!-- Hero Section -->
        <div class="row justify-content-center align-items-center mb-5">
            <div class="col-10">
                <div class="about-content">
                    <h1 class="about-title">Prensagem Térmica Profissional</h1>
                    <p class="about-subtitle">Alta Precisão e Produtividade</p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about-content">
                    <p class="about-description">Com mais de 30 anos de experiência com lâminas naturais e compostas, nossa empresa oferece um serviço de prensagem térmica altamente técnico e confiável, desenvolvido para atender as exigências da marcenaria profissional.</p>
                    <p class="about-description">Contamos com três prensas térmicas industriais, garantindo agilidade no fluxo de produção e prazos reduzidos, mesmo em volumes maiores. Entre os equipamentos, destacamos a SCM Sergiani GS 3000 x 1300, referência em performance, que assegura distribuição uniforme de temperatura e pressão em toda a área útil, essencial para prensagens sem falhas ou bolhas.</p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about-image-wrapper">
                    <img src="{{ asset('/storage/services/image_970-450.webp?1') }}" alt="Prensagem Térmica Profissional" class="img-fluid about-image">
                </div>
            </div>
        </div>

        <!-- Services Details -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title">Nossos Diferenciais</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3>Equipamentos de Alta Performance</h3>
                        <p>Prensas térmicas industriais, incluindo a SCM Sergiani GS 3000 x 1300, garantindo distribuição uniforme de temperatura e pressão.</p>
                    </div>

                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Cola D4 Estrutural</h3>
                        <p>Trabalhamos exclusivamente com cola D4, com alto desempenho estrutural e excelente resistência à umidade.</p>
                    </div>

                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3>Qualidade Garantida</h3>
                        <p>Processo conduzido com rigor técnico, resultando em painéis com excelente aderência e superfície uniforme.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="row">
            <div class="col-12">
                <div class="cta-section">
                    <h2>Precisa de prensagem térmica profissional?</h2>
                    <p>Entre em contato conosco e garanta qualidade e precisão em seus projetos</p>
                    @if(isset($getSettings['cellphone']) && $getSettings['cellphone'] != '')
                    <a href="https://wa.me/@formatPhone($getSettings['cellphone'])" target="_Blank" class="cta-button">
                        <i class="fab fa-whatsapp"></i>
                        Solicitar Orçamento
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection