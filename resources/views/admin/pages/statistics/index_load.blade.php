@if($results->count() > 0)
    <div class="table-responsive">
        <table class="table table-centered table-nowrap table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Valor</th>
                    <th>Ordem</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr id="row_statistic_{{ $result->id }}">
                    <td>{{ $result->id }}</td>
                    <td>{{ $result->title }}</td>
                    <td>{{ $result->value }}</td>
                    <td>{{ $result->sort_order }}</td>
                    <td>
                        @if($result->status)
                            <span class="badge bg-success">Habilitado</span>
                        @else
                            <span class="badge bg-danger">Desabilitado</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item button-statistics-edit" href="#" data-statistic-id="{{ $result->id }}">
                                    <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Editar
                                </a>
                                <!-- <a class="dropdown-item button-statistics-delete" href="#" data-statistic-id="{{ $result->id }}" data-statistic-title="{{ $result->title }}">
                                    <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Excluir
                                </a> -->
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($results->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $results->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
@else
    <div class="text-center py-4">
        <i class="mdi mdi-inbox-outline font-size-48 text-muted"></i>
        <h5 class="text-muted mt-2">Nenhuma estatística encontrada</h5>
        <p class="text-muted">Clique em "Adicionar" para criar uma nova estatística.</p>
    </div>
@endif


