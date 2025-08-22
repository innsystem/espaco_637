@extends('site.base')

@section('title', 'Sustentabilidade - Compromisso com o Meio Ambiente - Espaço 637')

@section('content')
<section class="about-section space-top space-bottom">
    <div class="container">
        <!-- Hero Section -->
        <div class="row justify-content-center align-items-center mb-5">
            <div class="col-lg-5">
                <div class="about-content">
                    <h1 class="about-title">Sustentabilidade</h1>
                    <p class="about-subtitle">Compromisso com o Futuro da Madeira</p>
                    <p class="about-description">No Espaço 637, compreendemos que trabalhar com lâminas de madeira é uma responsabilidade que vai além da qualidade do produto. É um compromisso com o meio ambiente e com as futuras gerações.</p>
                    
                    <p class="about-description">Nosso compromisso com a sustentabilidade permeia todos os aspectos de nossa operação, desde a seleção cuidadosa de fornecedores até a implementação de práticas responsáveis em nossos processos de produção.</p>
                    
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about-image-wrapper">
                    <img src="{{ asset('/storage/categories/category_1752675636.png') }}" alt="Sustentabilidade na Madeira" class="about-image">
                </div>
            </div>
        </div>

        <!-- Sustainability Practices -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title">Nossas Práticas Sustentáveis</h2>
                <div class="sustainability-grid">
                    <div class="sustainability-card">
                        <div class="sustainability-icon">
                            <i class="fas fa-tree"></i>
                        </div>
                        <h3>Origem Responsável</h3>
                        <p>Trabalhamos exclusivamente com fornecedores certificados que praticam manejo florestal sustentável, garantindo que toda madeira utilizada em nossas lâminas provém de florestas responsavelmente manejadas.</p>
                    </div>
                    
                    <div class="sustainability-card">
                        <div class="sustainability-icon">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <h3>Aproveitamento Máximo</h3>
                        <p>Maximizamos o aproveitamento de cada tora através de técnicas avançadas de corte, reduzindo drasticamente o desperdício e otimizando o uso dos recursos naturais.</p>
                    </div>
                    
                    <div class="sustainability-card">
                        <div class="sustainability-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3>Processos Limpos</h3>
                        <p>Utilizamos colas e adesivos com baixo teor de formaldeído, priorizando produtos eco-friendly que não comprometem a qualidade do ar interior.</p>
                    </div>
                    
                    <div class="sustainability-card">
                        <div class="sustainability-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3>Certificações</h3>
                        <p>Mantemos rigorosos padrões de qualidade ambiental, seguindo as principais certificações internacionais para produtos de madeira sustentável.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Future Commitments -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="section-title">Compromissos Futuros</h2>
                <div class="future-commitments">
                    <div class="commitment-item">
                        <div class="commitment-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="commitment-content">
                            <h4>Reflorestamento</h4>
                            <p>Apoiamos projetos de reflorestamento e conservação florestal, contribuindo para a regeneração de áreas degradadas e preservação da biodiversidade.</p>
                        </div>
                    </div>
                    
                    <div class="commitment-item">
                        <div class="commitment-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="commitment-content">
                            <h4>Inovação Sustentável</h4>
                            <p>Investimos continuamente em pesquisa e desenvolvimento de novas tecnologias que tornem nossos processos ainda mais eficientes e ecologicamente responsáveis.</p>
                        </div>
                    </div>
                    
                    <div class="commitment-item">
                        <div class="commitment-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="commitment-content">
                            <h4>Educação Ambiental</h4>
                            <p>Promovemos a conscientização sobre o uso sustentável da madeira, educando nossos clientes e parceiros sobre práticas responsáveis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection