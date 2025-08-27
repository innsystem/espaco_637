@extends('admin.base')

@section('title', 'Portfólios')

@section('content')
<div class="container">
    <div class="py-2 gap-2 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">@yield('title')</h4>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-success button-portfolios-create"><i class="fa fa-plus"></i> Adicionar</button>
            <button type="button" class="btn btn-sm btn-primary ms-2 button-portfolios-toggle-filters"><i class="fas fa-filter"></i> Filtros</button>
        </div>
    </div>
    <div id="content_filters" class="row d-none">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Nome:</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Digite o nome">
                            </div>
                            <div class="col-md-4">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1">Habilitado</option>
                                    <option value="2">Desabilitado</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="date_range">Período:</label>
                                <input type="text" id="date_range" name="date_range" class="form-control rangecalendar-period" placeholder="Selecione o intervalo">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="button" id="button-portfolios-filters" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="content-load-page" class="row">
                    </div><!-- row -->
                </div> <!-- end card body -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('pageMODAL')
<div class="offcanvas offcanvas-end" tabindex="-1" id="modalPortfolios" aria-labelledby="modalPortfoliosLabel" style="width:650px;">
    <div class="offcanvas-header">
        <h5 id="modalPortfoliosLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div> <!-- end offcanvas-header-->

    <div class="offcanvas-body" id="modal-content-portfolios">
    </div> <!-- end offcanvas-body-->
</div> <!-- end offcanvas-->

<!-- Image Cropper Modal for Portfolio -->
<div class="modal fade" id="portfolioImageCropperModal" tabindex="-1" aria-labelledby="portfolioImageCropperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="portfolioImageCropperModalLabel">Redimensionar Imagem do Portfólio</h5>
                <div class="ms-auto">
                    <span id="current-image-info" class="badge bg-info me-2"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" style="min-height: 500px;">
                <div class="img-container" style="height: 500px;">
                    <img id="portfolioCropperImage" src="" alt="Crop Image" style="max-width: 100%; max-height: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="skipCropBtn">Pular Recorte</button>
                <button type="button" class="btn btn-primary" id="cropAndSavePortfolio">Recortar e Salvar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pageCSS')
<!-- Quill css -->
<link href="{{ asset('/tpl_dashboard/vendor/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/tpl_dashboard/vendor/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/tpl_dashboard/vendor/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />

<!-- Flatpickr Timepicker css -->
<link href="{{ asset('/tpl_dashboard/vendor/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Cropper.js CSS -->
<link href="{{ asset('/plugins/croppperjs/cropper.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Sortable.js CSS -->
<style>
.portfolio-image-item {
    transition: all 0.3s ease;
    user-select: none;
}

.portfolio-image-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.portfolio-image-item.sortable-ghost {
    opacity: 0.5;
    transform: rotate(5deg);
}

.portfolio-image-item.sortable-chosen {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    z-index: 1000;
}

.portfolio-image-item.sortable-drag {
    opacity: 0.8;
}

.sortable-handle {
    cursor: move;
}

.sortable-handle:hover {
    background-color: #f8f9fa;
}
</style>
@endsection

@section('pageJS')
<!-- Quill Editor js -->
<script src="{{ asset('/tpl_dashboard/vendor/quill/quill.min.js') }}"></script>

<!-- Query String ToSlug - Transforma o titulo em URL amigavel sem acentos ou espaço -->
<script type="text/javascript" src="{{ asset('/plugins/stringToSlug/jquery.stringToSlug.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/stringToSlug/speakingurl.js') }}"></script>

<!-- Flatpickr Timepicker Plugin js -->
<script src="{{ asset('/tpl_dashboard/vendor/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('/tpl_dashboard/vendor/flatpickr/l10n/pt.js') }}"></script>

<!-- Cropper.js JS -->
<script src="{{ asset('/plugins/croppperjs/cropper.min.js') }}"></script>

<!-- Sortable.js -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    $(document).ready(function() {
        $("#date_range").flatpickr({
            "mode": "range",
            "dateFormat": "d/m/Y",
            "locale": "pt",
            "firstDayOfWeek": 1,
        });

        loadContentPage();
    });

    function loadContentPage(page = 1) {
        $("#content-load-page").html('<div class="text-center my-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Carregando...</p></div>');
        var url = `{{ url('/admin/portfolios/load') }}`;
        var filters = $('#filter-form').serialize();
        
        if(page > 1) {
            filters += '&page=' + page;
        }

        $.get(url + '?' + filters, function(data) {
            $("#content-load-page").html(data);
            
            // Remover manipuladores de eventos antigos para evitar duplicação
            $(document).off("click", ".pagination-link");
            
            // Adicionar novo manipulador de eventos para botões de paginação
            $(document).on("click", ".pagination-link", function(e) {
                e.preventDefault();
                var pageNum = $(this).data('page');
                loadContentPage(pageNum);
            });
        });
    }

    function initMasks() {
        // Inicializar o Quill Editor
        var snowEditor = new Quill('.snow-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: 'super'
                    }, {
                        script: 'sub'
                    }],
                    [{
                        header: [false, 1, 2, 3, 4, 5, 6]
                    }, 'blockquote', 'code-block'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }, {
                        indent: '-1'
                    }, {
                        indent: '+1'
                    }],
                    ['direction', {
                        align: []
                    }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Carregar conteúdo salvo no editor ao editar
        var existingContent = $('#description').val(); // Pega o valor do textarea
        if (existingContent) {
            snowEditor.root.innerHTML = existingContent; // Carrega no Quill Editor
        }

        $('input[name="title"]').stringToSlug({
            setEvents: 'keyup keydown blur',
            getPut: 'input[name="slug"]',
            space: '-',
            replace: '/\s?\([^\)]*\)/gi',
            AND: 'e'
        });
    }

    $(document).on("click", ".button-portfolios-toggle-filters", function(e) {
        e.preventDefault();

        $('#content_filters').toggleClass('d-none');
    });

    $(document).on("click", "#button-portfolios-filters", function(e) {
        e.preventDefault();

        loadContentPage();
    });

    $(document).on('change', '#images', function() {
        let files = this.files;
        let previewContainer = $('#preview-container');
        previewContainer.empty();

        Array.from(files).forEach((file, index) => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let imgPreview = `
                <div class="preview-item border rounded p-1" style="display: inline-block; margin-right: 10px; text-align: center;">
                    <img src="${e.target.result}" alt="Preview" class="avatar-md" style="object-fit: cover; margin-bottom: 5px;">
                </div>
            `;
                previewContainer.append(imgPreview);
            };
            reader.readAsDataURL(file);
        });
    });
</script>

<script>
    // Create
    $(document).on("click", ".button-portfolios-create", function(e) {
        e.preventDefault();

        $("#modal-content-portfolios").html('');
        $("#modalPortfoliosLabel").text('Nova Portfólio');
        var offcanvas = new bootstrap.Offcanvas($('#modalPortfolios'));
        offcanvas.show();

        var url = `{{ url('/admin/portfolios/create') }}`;
        $(this).addClass('modal-scrollfix');
        $.get(url, function(data) {
                $("#modal-content-portfolios").html(data);
                $(".button-portfolios-save").attr('data-type', 'store');
                initMasks();
            });
    });

    // Edit
    $(document).on("click", ".button-portfolios-edit", function(e) {
        e.preventDefault();

        let portfolio_id = $(this).data('portfolio-id');

        $("#modal-content-portfolios").html('');
        $("#modalPortfoliosLabel").text('Editar Portfólio');
        var offcanvas = new bootstrap.Offcanvas($('#modalPortfolios'));
        offcanvas.show();

        var url = `{{ url('/admin/portfolios/${portfolio_id}/edit') }}`;
        $(this).addClass('modal-scrollfix');
        $.get(url, function(data) {
                $("#modal-content-portfolios").html(data);
                $(".button-portfolios-save").attr('data-type', 'edit').attr('data-portfolio-id', portfolio_id);
                initMasks();
            });
    });

    // Save
    $(document).on('click', '.button-portfolios-save', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        let button = $(this);
        let portfolio_id = button.data('portfolio-id');
        var type = button.data('type');

        if (type == 'store') {
            var url = `{{ url('/admin/portfolios/store/') }}`;
        } else {
            if (portfolio_id) {
                var url = `{{ url('/admin/portfolios/${portfolio_id}/update') }}`;
            }
        }

        var snowEditor = new Quill('.snow-editor');
        $('#description').html(snowEditor.root.innerHTML);

        var form = $('#form-request-portfolios')[0];
        var formData = new FormData(form);

        $.ajax({
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            method: 'POST',
            beforeSend: function() {
                //disable the submit button
                button.attr("disabled", true);
                button.append('<i class="fa fa-spinner fa-spin ml-3"></i>');
            },
            complete: function() {
                button.prop("disabled", false);
                button.find('.fa-spinner').addClass('d-none');
            },
            success: function(data) {
                Swal.fire({
                    text: data,
                    icon: 'success',
                    showClass: {
                        popup: 'animate_animated animate_backInUp'
                    },
                    onClose: () => {
                        $("#modal-content-portfolios").html('');
                        var offcanvas = bootstrap.Offcanvas.getInstance($('#modalPortfolios'));
                        if (offcanvas) {
                            offcanvas.hide();
                        }
                        loadContentPage();
                    }
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    Swal.fire({
                        text: 'Validação: ' + xhr.responseJSON,
                        icon: 'warning',
                        showClass: {
                            popup: 'animate_animated animate_wobble'
                        }
                    });
                } else {
                    Swal.fire({
                        text: 'Erro Interno: ' + xhr.responseJSON,
                        icon: 'error',
                        showClass: {
                            popup: 'animate_animated animate_wobble'
                        }
                    });
                }
            }
        });
    });

    // Delete
    $(document).on('click', '.button-portfolios-delete', function(e) {
        e.preventDefault();
        let portfolio_id = $(this).data('portfolio-id');
        let portfolio_name = $(this).data('portfolio-name');

        Swal.fire({
            title: 'Deseja apagar ' + portfolio_name + '?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#333',
            confirmButtonText: 'Sim, apagar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: `{{ url('/admin/portfolios/${portfolio_id}/delete') }}`,
                    method: 'POST',
                    success: function(data) {
                        $('#row_portfolio_' + portfolio_id).remove();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            Swal.fire({
                                text: xhr.responseJSON,
                                icon: 'warning',
                                showClass: {
                                    popup: 'animate__animated animate__headShake'
                                }
                            });
                        } else {
                            Swal.fire({
                                text: xhr.responseJSON,
                                icon: 'error',
                                showClass: {
                                    popup: 'animate__animated animate__headShake'
                                }
                            });
                        }
                    }
                });
            }
        })
    });

    // Portfolio Image Cropping Variables
    let portfolioCropper = null;
    let portfolioImageQueue = [];
    let currentPortfolioImageIndex = 0;
    let processedPortfolioImages = [];

    // Initialize portfolio image cropping functionality
    function initializePortfolioImageCropping() {
        $(document).on('change', '#images', function(e) {
            const files = Array.from(e.target.files);
            
            if (files.length === 0) return;
            
            // Validate file sizes
            for (let file of files) {
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        text: 'Uma ou mais imagens são muito grandes. Por favor, selecione imagens menores que 5MB.',
                        icon: 'warning',
                        showClass: {
                            popup: 'animate__animated animate__wobble'
                        }
                    });
                    $(this).val('');
                    return;
                }
            }
            
            // Reset variables
            portfolioImageQueue = [];
            currentPortfolioImageIndex = 0;
            processedPortfolioImages = [];
            
            // Process each file
            files.forEach((file, index) => {
                processPortfolioImageForCropper(file, index);
            });
        });

        // Destroy cropper when modal is hidden
        $('#portfolioImageCropperModal').on('hidden.bs.modal', function() {
            destroyPortfolioCropper();
        });
    }

    // Process individual image for cropper
    function processPortfolioImageForCropper(file, index) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                // Resize large images before showing in cropper
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                let { width, height } = img;
                const maxSize = 1200;
                
                if (width > maxSize || height > maxSize) {
                    if (width > height) {
                        height = (height * maxSize) / width;
                        width = maxSize;
                    } else {
                        width = (width * maxSize) / height;
                        height = maxSize;
                    }
                }
                
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);
                
                portfolioImageQueue.push({
                    index: index,
                    name: file.name,
                    src: canvas.toDataURL(),
                    originalFile: file
                });
                
                // Start cropping process when all images are processed
                if (portfolioImageQueue.length === document.getElementById('images').files.length) {
                    startPortfolioCroppingProcess();
                }
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Start the cropping process for all images
    function startPortfolioCroppingProcess() {
        if (portfolioImageQueue.length === 0) return;
        
        currentPortfolioImageIndex = 0;
        showNextPortfolioImageForCropping();
    }

    // Show next image for cropping
    function showNextPortfolioImageForCropping() {
        if (currentPortfolioImageIndex >= portfolioImageQueue.length) {
            // All images processed, show summary
            showProcessedPortfolioImages();
            return;
        }
        
        const currentImage = portfolioImageQueue[currentPortfolioImageIndex];
        $('#current-image-info').text(`Imagem ${currentPortfolioImageIndex + 1} de ${portfolioImageQueue.length}: ${currentImage.name}`);
        
        showPortfolioCropperModal(currentImage.src);
    }

    // Show cropper modal and initialize cropper
    function showPortfolioCropperModal(imageSrc) {
        destroyPortfolioCropper();
        
        $('#portfolioCropperImage').attr('src', imageSrc);
        $('#portfolioImageCropperModal').modal('show');
        
        setTimeout(function() {
            initializePortfolioCropper();
        }, 300);
    }

    // Initialize cropper for portfolio images
    function initializePortfolioCropper() {
        const image = document.getElementById('portfolioCropperImage');
        if (!image || !image.src) return;
        
        portfolioCropper = new Cropper(image, {
            aspectRatio: 4/3, // Portfolio aspect ratio
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
            minContainerWidth: 200,
            minContainerHeight: 200,
            minCanvasWidth: 100,
            minCanvasHeight: 100,
            minCropBoxWidth: 50,
            minCropBoxHeight: 50,
            ready: function() {
                const containerData = portfolioCropper.getContainerData();
                const imageData = portfolioCropper.getImageData();
                
                // Set optimal crop area
                const aspectRatio = 4/3;
                let cropWidth, cropHeight;
                
                if (imageData.width / imageData.height > aspectRatio) {
                    cropHeight = imageData.height;
                    cropWidth = cropHeight * aspectRatio;
                } else {
                    cropWidth = imageData.width;
                    cropHeight = cropWidth / aspectRatio;
                }
                
                const left = (imageData.width - cropWidth) / 2;
                const top = (imageData.height - cropHeight) / 2;
                
                portfolioCropper.setCropBoxData({
                    left: left,
                    top: top,
                    width: cropWidth,
                    height: cropHeight
                });
            }
        });
    }

    // Destroy portfolio cropper
    function destroyPortfolioCropper() {
        if (portfolioCropper) {
            portfolioCropper.destroy();
            portfolioCropper = null;
        }
    }

    // Handle crop and save for portfolio
    $('#cropAndSavePortfolio').on('click', function() {
        if (portfolioCropper) {
            try {
                const canvas = portfolioCropper.getCroppedCanvas({
                    width: 800,
                    height: 600,
                    minWidth: 200,
                    minHeight: 150,
                    maxWidth: 1200,
                    maxHeight: 900,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });
                
                if (!canvas || canvas.width === 0 || canvas.height === 0) {
                    reinitializePortfolioCropper();
                    return;
                }
                
                canvas.toBlob(function(blob) {
                    if (!blob || blob.size === 0) {
                        reinitializePortfolioCropper();
                        return;
                    }
                    uploadCroppedPortfolioImage(blob);
                }, 'image/jpeg', 0.85);
                
            } catch (error) {
                console.error('Erro no cropper do portfólio:', error);
                reinitializePortfolioCropper();
            }
        }
    });

    // Skip cropping for current image
    $('#skipCropBtn').on('click', function() {
        const currentImage = portfolioImageQueue[currentPortfolioImageIndex];
        
        // Use original image without cropping
        const formData = new FormData();
        formData.append('image', currentImage.originalFile);
        
        uploadOriginalPortfolioImage(formData);
    });

    // Upload cropped portfolio image
    function uploadCroppedPortfolioImage(blob) {
        const formData = new FormData();
        const currentImage = portfolioImageQueue[currentPortfolioImageIndex];
        formData.append('image', blob, `cropped_${currentImage.name}`);
        
        uploadPortfolioImageToServer(formData);
    }

    // Upload original portfolio image (when skipping crop)
    function uploadOriginalPortfolioImage(formData) {
        uploadPortfolioImageToServer(formData);
    }

    // Upload image to server
    function uploadPortfolioImageToServer(formData) {
        // Try multiple ways to get portfolio_id
        let portfolioId = null;
        
        // Method 1: From form data attribute
        portfolioId = $('#form-request-portfolios').data('portfolio-id');
        
        // Method 2: From form attribute directly
        if (!portfolioId) {
            portfolioId = $('#form-request-portfolios').attr('data-portfolio-id');
        }
        
        // Method 3: From URL if we're in edit mode
        if (!portfolioId) {
            const currentUrl = window.location.href;
            const editMatch = currentUrl.match(/\/portfolios\/(\d+)\/edit/);
            if (editMatch) {
                portfolioId = editMatch[1];
            }
        }
        
        // Method 4: From any edit button that might be active
        if (!portfolioId) {
            const activeEditButton = $('.button-portfolios-edit.active, .button-portfolios-save[data-portfolio-id]');
            if (activeEditButton.length > 0) {
                portfolioId = activeEditButton.data('portfolio-id');
            }
        }
        
        console.log('Debug: portfolio_id final:', portfolioId);
        
        if (portfolioId && portfolioId !== '' && portfolioId !== 'undefined') {
            formData.append('portfolio_id', portfolioId);
            console.log('Debug: portfolio_id adicionado ao FormData:', portfolioId);
        } else {
            console.log('Debug: Nenhum portfolio_id válido encontrado - upload sem relação');
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        
        $.ajax({
            url: `{{ url('/admin/portfolios/upload-image') }}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    const currentImage = portfolioImageQueue[currentPortfolioImageIndex];
                    processedPortfolioImages.push({
                        ...currentImage,
                        uploadedData: response,
                        image_path: response.image_path
                    });
                    
                    // Update hidden field with processed images
                    updateProcessedImagesField();
                    
                    $('#portfolioImageCropperModal').modal('hide');
                    
                    // Move to next image
                    currentPortfolioImageIndex++;
                    setTimeout(() => {
                        showNextPortfolioImageForCropping();
                    }, 500);
                }
            },
            error: function(xhr) {
                $('#portfolioImageCropperModal').modal('hide');
                let errorMessage = 'Erro ao carregar imagem';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += ': ' + xhr.responseJSON.message;
                }
                
                Swal.fire({
                    text: errorMessage,
                    icon: 'error',
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp'
                    }
                });
            }
        });
    }

    // Delete Image
    $(document).on('click', '.button-portfolio-images-delete', function(e) {
        e.preventDefault();
        let portfolio_image_id = $(this).data('portfolio-image-id');
        let portfolio_name = $(this).data('portfolio-name');

        Swal.fire({
            title: 'Deseja apagar a imagem do ' + portfolio_name + '?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#333',
            confirmButtonText: 'Sim, apagar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: `{{ url('/admin/portfolios/${portfolio_image_id}/delete-image') }}`,
                    method: 'POST',
                    success: function(data) {
                        $('#row_portfolio_image_' + portfolio_image_id).remove();
                        loadContentPage();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            Swal.fire({
                                text: xhr.responseJSON,
                                icon: 'warning',
                                showClass: {
                                    popup: 'animate__animated animate__headShake'
                                }
                            });
                        } else {
                            Swal.fire({
                                text: xhr.responseJSON,
                                icon: 'error',
                                showClass: {
                                    popup: 'animate__animated animate__headShake'
                                }
                            });
                        }
                    }
                });
            }
        })
    });

    $(document).on('change', 'input[name="thumb_portfolio"]', function() {
        let image_id = $(this).val(); // ID da imagem selecionada
        let portfolio_id = $('#form-request-portfolios').data('portfolio-id'); // ID do portfólio

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            url: `/admin/portfolios/${portfolio_id}/define-image-thumb`,
            method: 'POST',
            data: {
                image_id: image_id
            },
            success: function(response) {
                loadContentPage();
            },
            error: function(xhr) {
                $('#portfolioImageCropperModal').modal('hide');
                let errorMessage = 'Erro ao carregar imagem';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += ': ' + xhr.responseJSON.message;
                }
                
                Swal.fire({
                    text: errorMessage,
                    icon: 'error',
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp'
                    }
                });
            }
        });
    });

    // Reinitialize cropper on error
    function reinitializePortfolioCropper() {
        destroyPortfolioCropper();
        setTimeout(function() {
            initializePortfolioCropper();
        }, 100);
    }

    // Update hidden field with processed images
    function updateProcessedImagesField() {
        const imageData = processedPortfolioImages.map(img => ({
            image_path: img.image_path,
            name: img.name
        }));
        
        // Add or update hidden field in form
        let hiddenField = $('#uploaded_images');
        if (hiddenField.length === 0) {
            $('#form-request-portfolios').append('<input type="hidden" id="uploaded_images" name="uploaded_images">');
            hiddenField = $('#uploaded_images');
        }
        hiddenField.val(JSON.stringify(imageData));
    }

    // Show processed images summary
    function showProcessedPortfolioImages() {
        let summaryHtml = '<div class="alert alert-success"><h6>Imagens processadas com sucesso!</h6><ul>';
        
        processedPortfolioImages.forEach((img, index) => {
            summaryHtml += `<li>${img.name} - Convertida para WebP</li>`;
        });
        
        summaryHtml += '</ul></div>';
        
        $('#processed-images').html(summaryHtml);
        
        // Update hidden field with all processed images
        updateProcessedImagesField();
        
        // Clear the file input to prevent duplicate processing
        $('#images').val('').prop('files', null);
        
        // Remove the name attribute from images input to prevent form submission
        $('#images').removeAttr('name');
        
        Swal.fire({
            title: 'Sucesso!',
            text: `${processedPortfolioImages.length} imagem(ns) processada(s) e convertida(s) para WebP. As imagens serão associadas ao portfólio quando você salvar.`,
            icon: 'success',
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            }
        });
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initializePortfolioImageCropping();
        initializePortfolioImageSortable();
    });

    // Initialize Sortable for portfolio images
    function initializePortfolioImageSortable() {
        const container = document.getElementById('portfolio-images-container');
        if (!container) return;

        new Sortable(container, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            handle: '.portfolio-image-item',
            onEnd: function(evt) {
                updatePortfolioImageOrder();
            }
        });
    }

    // Update portfolio image order after drag and drop
    function updatePortfolioImageOrder() {
        const container = document.getElementById('portfolio-images-container');
        if (!container) return;

        const imageItems = container.querySelectorAll('.portfolio-image-item');
        const imageOrders = [];

        imageItems.forEach((item, index) => {
            const imageId = item.getAttribute('data-id');
            if (imageId) {
                imageOrders.push(imageId);
                
                // Update the order number display
                const orderBadge = item.querySelector('.position-absolute');
                if (orderBadge) {
                    orderBadge.textContent = index + 1;
                }
                
                // Update data-sort-order attribute
                item.setAttribute('data-sort-order', index);
            }
        });

        // Get portfolio ID
        const portfolioId = $('#form-request-portfolios').data('portfolio-id');
        if (!portfolioId) {
            console.error('Portfolio ID not found');
            return;
        }

        // Send AJAX request to update order
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            url: `{{ url('/admin/portfolios/${portfolioId}/reorder-images') }}`,
            method: 'POST',
            data: {
                image_orders: imageOrders
            },
            success: function(response) {
                // Show success message
                Swal.fire({
                    text: 'Ordem das imagens atualizada com sucesso!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp'
                    }
                });
            },
            error: function(xhr) {
                console.error('Erro ao atualizar ordem das imagens:', xhr);
                Swal.fire({
                    text: 'Erro ao atualizar ordem das imagens',
                    icon: 'error',
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp'
                    }
                });
            }
        });
    }

    // Re-initialize sortable when form is loaded (for edit mode)
    $(document).on('shown.bs.offcanvas', '#modalPortfolios', function() {
        setTimeout(function() {
            initializePortfolioImageSortable();
        }, 500);
    });
</script>
@endsection