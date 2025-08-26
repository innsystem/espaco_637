<form id="form-request-statistics">
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="title" class="col-sm-12">Título:</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título" value="{{ isset($result->title) ? $result->title : '' }}">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="value" class="col-sm-12">Valor:</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="value" name="value" placeholder="Digite o valor" value="{{ isset($result->value) ? $result->value : '' }}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="sort_order" class="col-sm-12">Ordem:</label>
            <div class="col-sm-12">
                <input type="number" class="form-control" id="sort_order" name="sort_order" placeholder="Digite a ordem" value="{{ isset($result->sort_order) ? $result->sort_order : '0' }}">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="status" class="col-sm-12">Status:</label>
            <div class="col-sm-12">
                <select name="status" id="status" class="form-select">
                    @foreach($statuses as $status)
                    <option value="{{$status->id}}" @if (isset($result->status) && $result->status == $status->id) selected @endif>{{$status->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="bg-gray modal-footer justify-content-between">
        <button type="button" class="btn btn-success button-statistics-save"><i class="fa fa-check"></i> Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas" aria-label="Fechar">Fechar</button>
    </div>
</form>


