// Variável global para armazenar o campo atual
let currentIconField = null;

// Função para abrir a galeria de ícones
function openIconGallery(fieldName) {
    currentIconField = fieldName;
    
    // Limpar seleção anterior
    document.querySelectorAll('#globalIconGrid .icon-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Limpar busca
    document.getElementById('globalIconSearch').value = '';
    
    // Mostrar todos os ícones
    document.querySelectorAll('#globalIconGrid .icon-item').forEach(item => {
        item.style.display = 'flex';
    });
    
    // Abrir modal
    const modal = new bootstrap.Modal(document.getElementById('globalIconGalleryModal'));
    modal.show();
}

// Inicializar galeria de ícones global
document.addEventListener('DOMContentLoaded', function() {
    let selectedIcon = '';
    
    // Busca de ícones
    const searchInput = document.getElementById('globalIconSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const iconItems = document.querySelectorAll('#globalIconGrid .icon-item');
            
            iconItems.forEach(item => {
                const iconText = item.querySelector('small').textContent.toLowerCase();
                const iconClass = item.querySelector('i').className.toLowerCase();
                
                if (iconText.includes(searchTerm) || iconClass.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
    
    // Seleção de ícone
    const iconItems = document.querySelectorAll('#globalIconGrid .icon-item');
    iconItems.forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('#globalIconGrid .icon-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            selectedIcon = this.getAttribute('data-icon');
        });
    });
    
    // Confirmar seleção
    const selectButton = document.getElementById('globalSelectIcon');
    if (selectButton) {
        selectButton.addEventListener('click', function() {
            if (selectedIcon && currentIconField) {
                document.getElementById(currentIconField).value = selectedIcon;
                const modal = bootstrap.Modal.getInstance(document.getElementById('globalIconGalleryModal'));
                if (modal) {
                    modal.hide();
                }
            }
        });
    }
    
    // Listener para botões de galeria de ícones
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('icon-gallery-btn')) {
            e.preventDefault();
            const fieldName = e.target.getAttribute('data-field');
            if (fieldName) {
                openIconGallery(fieldName);
            }
        }
    });
});
