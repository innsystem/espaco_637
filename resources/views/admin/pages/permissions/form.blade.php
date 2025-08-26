<form id="form-request-permissions">
    <div class="modal-body">
        <div class="mb-3">
            <label for="routes-select" class="form-label">Selecionar Rotas</label>
            <select id="routes-select" name="routes[]" class="form-select" multiple size="8">
                @foreach($routes as $route)
                <option value="{{$route['uri']}}" data-name="{{$route['name']}}">{{$route['name']}} ({{$route['uri']}})</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Use Ctrl+Click (ou Cmd+Click no Mac) para selecionar múltiplas rotas</small>
        </div>
        
        <div id="permissions-rows">
            <!-- As linhas de permissões serão geradas dinamicamente aqui -->
        </div>
        
        <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="generate-permissions"><i class="fa fa-magic"></i> Gerar Permissões</button>
    </div>
    <div class="bg-gray modal-footer justify-content-between">
        <button type="button" class="btn btn-success button-permissions-save"><i class="fa fa-check"></i> Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas" aria-label="Fechar">Fechar</button>
    </div>
</form>