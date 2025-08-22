@extends('site.base')

@section('title', 'Lâminas de Madeira')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-2">@yield('title')</h1>
        </div>
    </div>

    <!-- Categories Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('site.categories.index') }}" class="btn btn-primary">Todos</a>
                @foreach($categories as $cat)
                <a href="{{ route('site.products.category', $cat->slug) }}" class="btn btn-outline-primary">{{ $cat->title }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        @if(count($products) > 0)
        @foreach($products as $product)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="product-card">
                @if($product->image)
                <div class="product-image-container">
                    <a href="{{ route('site.product.detail', $product->slug) }}">
                        <img src="{{ asset('storage/'.$product->image) }}" class="product-image" alt="{{ $product->title }}">
                    </a>
                    <div class="product-category-badge">{{ $product->category->title }}</div>
                </div>
                @endif
                <div class="product-info">
                    <h5 class="product-title no-subtitle"><a href="{{ route('site.product.detail', $product->slug) }}">{{ $product->title }}</a></h5>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-12">
            <div class="alert alert-info">
                <h4>Nenhum produto encontrado</h4>
                <p>Não há produtos disponíveis nesta categoria no momento.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection