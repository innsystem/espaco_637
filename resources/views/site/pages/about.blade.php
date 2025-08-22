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
                    <p class="about-subtitle">Tradição e qualidade em lâminas</p>
                    <p class="about-description">O Espaço 637 é uma empresa especializada na comercialização da mais alta qualidade de lâminas de madeira natural. Nossas lâminas são cuidadosamente selecionadas para garantir não apenas beleza, mas também durabilidade e praticidade.    Com um forte compromisso em facilitar o dia a dia de nossos clientes e parceiros estamos sempre prontos para orientar e auxiliá-los na escolha dos produtos mais adequados.  Acreditamos que, ao oferecer o melhor em lâminas, contribuímos para a realização de projetos únicos e inspiradores.</p>
                    <div class="about-stats">
                        <div class="stat-item">
                            <span class="stat-number">100+</span>
                            <span class="stat-label">Clientes Satisfeitos</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">30+</span>
                            <span class="stat-label">Anos de Experiência</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-image-wrapper">
                    <img src="{{ asset('/storage/abouts/image_404-633.webp?1') }}" alt="Espaço 637 Marcenaria" class="about-image">
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="row">
            <div class="col-12">
                <div class="cta-section">
                    <h2>Pronto para realizar seu projeto?</h2>
                    <p>Entre em contato conosco e transforme sua ideia em realidade</p>
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

