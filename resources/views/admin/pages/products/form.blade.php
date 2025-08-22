<form id="form-request-products">
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="category_id" class="col-sm-12">Categoria:</label>
            <div class="col-sm-12">
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" @if (isset($result->category_id) && $result->category_id == $category->id) selected @endif>{{$category->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="title" class="col-sm-12">Título do Produto:</label>
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
                    
                    <div id="image-preview" class="mt-3" style="display: {{ isset($result->image) && $result->image ? 'block' : 'none' }};">
                        <img id="preview-img" src="{{ isset($result->image) && $result->image ? asset('storage/' . $result->image) : '' }}" alt="Preview" style="max-width: 200px; max-height: 200px;">
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-danger" id="remove-image-btn">Remover</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-none">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="price" class="col-sm-12">Preço:</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control mask-money" id="price" name="price" placeholder="R$ 0,00" value="{{ isset($result->price) ? $result->price : '' }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="stock" class="col-sm-12">Estoque:</label>
                    <div class="col-sm-12">
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Digite o estoque" value="{{ isset($result->stock) ? $result->stock : '0' }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="status" class="col-sm-12">Status do Produto:</label>
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
        <button type="button" class="btn btn-success button-products-save"><i class="fa fa-check"></i> Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas" aria-label="Fechar">Fechar</button>
    </div>
</form>