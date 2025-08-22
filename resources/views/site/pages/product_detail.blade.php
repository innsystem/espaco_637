@extends('site.base')

@section('title', $product->title)

@section('content')
<section class="space-top space-bottom product-detail-section">
    <div class="container product-container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="product-image-wrapper">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="product-content">
                    <h1 class="product-title-details">{{ $product->title }}</h1>
                    <p class="product-description">{{ $product->description }}</p>
                    <a href="{{ route('site.index') }}" class="back-button">
                        <i class="fas fa-home"></i>
                        Início
                    </a>
                    <a href="{{ route('site.categories.index') }}" class="back-button ms-4">
                        <i class="fas fa-bars"></i>
                        Ver categoria
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

