<form id="form-request-categories">
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="title" class="col-sm-12">Título da Categoria:</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título" value="{{ isset($result->title) ? $result->title : '' }}">
            </div>
        </div>
        <div class="form-group mb-3 d-none">
            <label for="slug" class="col-sm-12">URL Amigável:</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="slug" name="slug" placeholder="Digite o slug" value="{{ isset($result->slug) ? $result->slug : '' }}">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="description" class="col-sm-12">Descrição:</label>
            <div class="col-sm-12">
                <textarea class="form-control" id="description" name="description" placeholder="Digite a descrição" rows="3">{{ isset($result->description) ? $result->description : '' }}</textarea>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="image" class="col-sm-12">Imagem:</label>
            <div class="col-sm-12">
                <div class="image-upload-container">
                    <input type="hidden" id="image" name="image" value="{{ isset($result->image) ? $result->image : '' }}">
                    <input type="file" id="image-upload" class="form-control" accept="image/*">
                    <button type="button" class="btn btn-primary mt-2" id="upload-image-btn">Selecionar Imagem</button>
                    
                    <div id="image-preview" class="mt-3" style="{{ isset($result->image) && $result->image ? 'display: block;' : 'display: none;' }}">
                        <img id="preview-img" src="{{ isset($result->image) && $result->image ? asset('storage/' . $result->image) : '' }}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-danger" id="remove-image-btn">Remover</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="order" class="col-sm-12">Ordem:</label>
            <div class="col-sm-12">
                <input type="number" class="form-control" id="order" name="order" placeholder="Digite a ordem" value="{{ isset($result->order) ? $result->order : '0' }}">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="status" class="col-sm-12">Status da Categoria:</label>
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
        <button type="button" class="btn btn-success button-categories-save"><i class="fa fa-check"></i> Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas" aria-label="Fechar">Fechar</button>
    </div>
</form>