@if(isset($results) && count($results) > 0)
@foreach($results as $category)
<div id="row_category_{{$category->id}}" class="col-12 pb-2 mb-4 border-bottom rounded">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <div class="flex-grow-1 d-flex align-items-center">
            @if($category->image)
            <div class="pe-2">
                <img src="{{ asset('storage/'.$category->image) }}" class="img-fluid rounded-circle" alt="{{ $category->title }}" style="height: 60px; object-fit: cover;">
            </div>
            @endif

            <div>
                <h5 class="h6 mb-1 fw-bold">{{$category->title}}</h5>
                <p class="text-muted mb-0">
                    @if($category->description)
                    {{ Str::limit($category->description, 100) }}
                    @else
                    Sem descrição
                    @endif
                </p>
                <small class="text-muted">Ordem: {{$category->order}}</small>
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-info button-categories-edit" data-category-id="{{$category->id}}">Editar</button>
            <button type="button" class="btn btn-sm btn-danger button-categories-delete" data-category-id="{{$category->id}}" data-category-name="{{$category->title}}">Apagar</button>
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