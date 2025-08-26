@props(['name' => 'icon', 'value' => '', 'label' => 'Ícone'])

<div class="form-group mb-3">
    <label for="{{ $name }}" class="col-sm-12">{{ $label }}:</label>
    <div class="col-sm-12">
        <div class="input-group">
            <input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}" 
                   placeholder="Ex: fas fa-heart" value="{{ $value }}" readonly>
            <button type="button" class="btn btn-outline-secondary icon-gallery-btn" data-field="{{ $name }}">
                <i class="fas fa-icons"></i> Escolher Ícone
            </button>
        </div>
    </div>
</div>

