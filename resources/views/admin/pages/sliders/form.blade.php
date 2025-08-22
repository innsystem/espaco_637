<form id="form-request-sliders">
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="title" class="col-sm-12">Título do Slider:</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título" value="{{ isset($result->title) ? $result->title : '' }}">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="subtitle" class="col-sm-12">Subtítulo do Slider:</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Digite o subtítulo" value="{{ isset($result->subtitle) ? $result->subtitle : '' }}">
            </div>
        </div>
        <div class="form-group mb-3 d-none">
            <label for="href" class="col-sm-12">Link (URL):</label>
            <div class="col-sm-12">
                <input type="url" class="form-control" id="href" name="href" placeholder="Ex: https://www.seusite.com.br/pagina" value="{{ isset($result->href) ? $result->href : '' }}">
            </div>
        </div>
        <div class="form-group mb-3 d-none">
            <label for="target" class="col-sm-12">Abrir Link em:</label>
            <div class="col-sm-12">
                <select name="target" id="target" class="form-select">
                    <option value="_self" @if (isset($result->target) && $result->target == '_self') selected @endif>Mesma Aba</option>
                    <option value="_blank" @if (isset($result->target) && $result->target == '_blank') selected @endif>Nova Aba</option>
                </select>
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
                        <img id="preview-img" src="{{ isset($result->image) && $result->image ? asset('storage/' . $result->image) : '' }}" alt="Preview" style="max-width: 100%; max-height: 200px;">
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
                    <label for="date_start" class="col-sm-12">Data Início:</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control flatpickr-datetime" id="date_start" name="date_start" placeholder="DD/MM/AAAA HH:mm" value="{{ isset($result->date_start) ? \Carbon\Carbon::parse($result->date_start)->format('d/m/Y H:i') : '' }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="date_end" class="col-sm-12">Data Fim:</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control flatpickr-datetime" id="date_end" name="date_end" placeholder="DD/MM/AAAA HH:mm" value="{{ isset($result->date_end) ? \Carbon\Carbon::parse($result->date_end)->format('d/m/Y H:i') : '' }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="status" class="col-sm-12">Status do Slider:</label>
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
        <button type="button" class="btn btn-success button-sliders-save"><i class="fa fa-check"></i> Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas" aria-label="Fechar">Fechar</button>
    </div>
</form>