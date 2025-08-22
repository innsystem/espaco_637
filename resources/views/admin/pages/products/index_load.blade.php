@if(isset($results) && count($results) > 0)
@foreach($results as $product)
<div id="row_product_{{$product->id}}" class="col-12 pb-2 mb-4 border-bottom rounded">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <div class="flex-grow-1 d-flex align-items-center">
            @if($product->image)
            <div class="pe-2">
                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded-circle" alt="{{ $product->title }}" style="height: 60px; object-fit: cover;">
            </div>
            @endif

            <div>
                <h5 class="h5 mb-1 fw-bold">{{$product->title}}</h5>
                <p class="text-muted mb-0">
                    <strong>Categoria:</strong> {{ $product->category->title ?? 'N/A' }} | 
                    <!-- <strong>Preço:</strong> {{ $product->formatted_price }} |  -->
                    <!-- <strong>Estoque:</strong> {{ $product->stock }} -->
                </p>
                @if($product->description)
                <p class="text-muted mb-0 mt-1">
                    {{ Str::limit($product->description, 80) }}
                </p>
                @endif
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-info button-products-edit" data-product-id="{{$product->id}}">Editar</button>
            <button type="button" class="btn btn-sm btn-danger button-products-delete" data-product-id="{{$product->id}}" data-product-name="{{$product->title}}">Apagar</button>
        </div>
    </div>
</div><!-- col-12 -->
@endforeach

<div class="d-flex justify-content-center mt-4 pagination-container">
    <nav aria-label="Navegação da paginação">
        <ul class="pagination">
            @if($results->currentPage() > 1)
                <li class="page-item">
                    <button class="page-link pagination-link" data-page="{{ $results->currentPage() - 1 }}">Anterior</button>
                </li>
            @endif

            @for($i = 1; $i <= $results->lastPage(); $i++)
                <li class="page-item {{ $results->currentPage() == $i ? 'active' : '' }}">
                    <button class="page-link pagination-link" data-page="{{ $i }}">{{ $i }}</button>
                </li>
            @endfor

            @if($results->currentPage() < $results->lastPage())
                <li class="page-item">
                    <button class="page-link pagination-link" data-page="{{ $results->currentPage() + 1 }}">Próximo</button>
                </li>
            @endif
        </ul>
    </nav>
</div>

@else
<div class="alert alert-warning mb-0">Nenhum resultado foi localizado...</div>
@endif