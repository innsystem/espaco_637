@extends('admin.base')

@section('title', 'Atalhos Administrativos')

@section('content')
<div class="container">
    <div class="py-2 gap-2 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">@yield('title')</h4>
        </div>
    </div>
    <div class="row mt-4 justify-content-center">
        <!-- Atalho para Sliders -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="h3 fw-bold card-title">Gerenciar Sliders</h5>
                    <p class="card-text">Acesse para configurar os banners e carrosséis do site.</p>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">Ir para Sliders</a>
                </div>
            </div>
        </div>

        <!-- Atalho para Categorias -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="h3 fw-bold card-title">Gerenciar Categorias</h5>
                    <p class="card-text">Visualize e edite as categorias de produtos.</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-success">Ir para Categorias</a>
                </div>
            </div>
        </div>

        <!-- Atalho para Produtos -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="h3 fw-bold card-title">Gerenciar Produtos</h5>
                    <p class="card-text">Adicione, edite ou remova produtos do seu catálogo.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-info">Ir para Produtos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pageMODAL')
@endsection

@section('pageCSS')
@endsection

@section('pageJS')
@endsection