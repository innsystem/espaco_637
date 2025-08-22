@extends('admin.base')

@section('title', 'Produtos')

@section('content')
<div class="container">
    <div class="py-2 gap-2 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">@yield('title')</h4>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-success button-products-create"><i class="fa fa-plus"></i> Adicionar</button>
            <button type="button" class="btn btn-sm btn-primary ms-2 button-products-toggle-filters"><i class="fas fa-filter"></i> Filtros</button>
        </div>
    </div>
    <div id="content_filters" class="row d-none">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="name">Nome:</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Digite o nome">
                            </div>
                            <div class="col-md-3">
                                <label for="category_id">Categoria:</label>
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="">Todas</option>
                                    @php
                                        $categories = App\Models\Category::active()->ordered()->get();
                                    @endphp
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1">Habilitado</option>
                                    <option value="2">Desabilitado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date_range">Período:</label>
                                <input type="text" id="date_range" name="date_range" class="form-control rangecalendar-period" placeholder="Selecione o intervalo">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="button" id="button-products-filters" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Filtrar</button>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="modalProducts" aria-labelledby="modalProductsLabel">
    <div class="offcanvas-header">
        <h5 id="modalProductsLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div> <!-- end offcanvas-header-->

    <div class="offcanvas-body" id="modal-content-products">
    </div> <!-- end offcanvas-body-->
</div> <!-- end offcanvas-->

<!-- Image Cropper Modal -->
<div class="modal fade" id="imageCropperModal" tabindex="-1" aria-labelledby="imageCropperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageCropperModalLabel">Redimensionar Imagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 500px;">
                <div class="img-container" style="height: 500px;">
                    <img id="cropperImage" src="" alt="Crop Image" style="max-width: 100%; max-height: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="cropAndSave">Cortar e Salvar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pageCSS')
<!-- Flatpickr Timepicker css -->
<link href="{{ asset('/tpl_dashboard/vendor/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Cropper.js CSS -->
<link href="{{ asset('/plugins/croppperjs/cropper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('pageJS')
<!-- Query String ToSlug - Transforma o titulo em URL amigavel sem acentos ou espaço -->
<script type="text/javascript" src="{{ asset('/plugins/stringToSlug/jquery.stringToSlug.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/stringToSlug/speakingurl.js') }}"></script>

<!-- Flatpickr Timepicker Plugin js -->
<script src="{{ asset('/tpl_dashboard/vendor/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('/tpl_dashboard/vendor/flatpickr/l10n/pt.js') }}"></script>

<!-- Mask Money Plugin js -->
<script src="{{ asset('/plugins/jquery.mask.js') }}"></script>

<!-- Cropper.js JS -->
<script src="{{ asset('/plugins/croppperjs/cropper.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#date_range").flatpickr({
            "mode": "range",
            "dateFormat": "d/m/Y",
            "locale": "pt", // Configuração para português
            "firstDayOfWeek": 1, // Inicia a semana na segunda-feira
        });

        loadContentPage();
    });

    function loadContentPage(page = 1) {
        $("#content-load-page").html('<div class="text-center my-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Carregando...</p></div>');
        var url = `{{ url('/admin/products/load') }}`;
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

    let cropper = null;
    let currentImageFile = null;
    let currentImageSrc = null;

    function initMasks() {
        $('input[name="title"]').stringToSlug({
            setEvents: 'keyup keydown blur',
            getPut: 'input[name="slug"]',
            space: '-',
            replace: '/\s?\([^\)]*\)/gi',
            AND: 'e'
        });

        $('.mask-money').mask('000.000.000.000.000,00', {reverse: true});
        
        initImageUpload();
    }

    function initImageUpload() {
        // Hide the file input and show custom button
        $('#image-upload').hide();
        
        // Handle upload button click
        $('#upload-image-btn').on('click', function() {
            $('#image-upload').click();
        });

        // Handle file selection
        $('#image-upload').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                currentImageFile = file;
                
                // Check file size (limit to 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        text: 'A imagem é muito grande. Por favor, selecione uma imagem menor que 5MB.',
                        icon: 'warning',
                        showClass: {
                            popup: 'animate__animated animate__wobble'
                        }
                    });
                    $(this).val('');
                    return;
                }
                
                // Process and show image in cropper modal
                processImageForCropper(file);
            }
        });

        // Destroy cropper when modal is hidden
        $('#imageCropperModal').on('hidden.bs.modal', function() {
            destroyCropper();
        });
    }

    // Function to process image for cropper
    function processImageForCropper(file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                // Resize large images before showing in cropper
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                let { width, height } = img;
                const maxSize = 1200; // Maximum dimension
                
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
                
                currentImageSrc = canvas.toDataURL();
                showCropperModal();
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Function to show cropper modal and initialize cropper
    function showCropperModal() {
        // Destroy existing cropper if any
        destroyCropper();
        
        // Set image source and show modal
        $('#cropperImage').attr('src', currentImageSrc);
        $('#imageCropperModal').modal('show');
        
        // Initialize cropper after modal is shown
        setTimeout(function() {
            initializeCropper();
        }, 300);
    }

    // Function to initialize cropper
    function initializeCropper() {
        const image = document.getElementById('cropperImage');
        if (!image || !image.src) return;
        
        cropper = new Cropper(image, {
            aspectRatio: 1, // Square crop
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1.0, // 100% crop area
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
            responsive: true,
            checkCrossOrigin: false,
            checkOrientation: false,
            modal: true,
            background: true,
            minContainerWidth: 200,
            minContainerHeight: 200,
            minCanvasWidth: 0,
            minCanvasHeight: 0,
            minCropBoxWidth: 50,
            minCropBoxHeight: 50,
            ready: function() {
                // Ensure the image fits properly and crop area is maximum
                const containerData = cropper.getContainerData();
                const imageData = cropper.getImageData();
                
                // Calculate the maximum square crop area that fits within the image
                const minDimension = Math.min(imageData.width, imageData.height);
                const left = (imageData.width - minDimension) / 2;
                const top = (imageData.height - minDimension) / 2;
                
                // Set crop box to maximum square area
                cropper.setCropBoxData({
                    left: left,
                    top: top,
                    width: minDimension,
                    height: minDimension
                });
            }
        });
    }

    // Function to destroy cropper
    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    // Function to reinitialize cropper on error
    function reinitializeCropper() {
        destroyCropper();
        setTimeout(function() {
            initializeCropper();
        }, 100);
    }

    // Handle crop and save
    $('#cropAndSave').on('click', function() {
        if (cropper) {
            try {
                // Get cropped canvas with safe settings
                const canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                    minWidth: 100,
                    minHeight: 100,
                    maxWidth: 800,
                    maxHeight: 800,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });
                
                if (!canvas) {
                    throw new Error('canvas_error');
                }
                
                // Validate canvas dimensions
                if (canvas.width === 0 || canvas.height === 0) {
                    throw new Error('canvas_error');
                }
                
                // Check if toBlob is supported
                if (!canvas.toBlob) {
                    // Fallback for older browsers
                    const dataURL = canvas.toDataURL('image/jpeg', 0.85);
                    if (!dataURL || dataURL === 'data:,') {
                        throw new Error('canvas_error');
                    }
                    const blob = dataURLtoBlob(dataURL);
                    uploadCroppedImage(blob);
                } else {
                    canvas.toBlob(function(blob) {
                        if (!blob || blob.size === 0) {
                            // Reinitialize cropper on error
                            reinitializeCropper();
                            return;
                        }
                        uploadCroppedImage(blob);
                    }, 'image/jpeg', 0.85);
                }
            } catch (error) {
                console.error('Erro no cropper:', error);
                
                // If it's a canvas error, reinitialize cropper
                if (error.message === 'canvas_error') {
                    reinitializeCropper();
                } else {
                    Swal.fire({
                        text: 'Erro ao processar a imagem. Reinicializando o editor...',
                        icon: 'info',
                        timer: 1500,
                        showClass: {
                            popup: 'animate__animated animate__fadeInUp'
                        }
                    });
                    reinitializeCropper();
                }
            }
        }
    });

    // Function to upload cropped image
    function uploadCroppedImage(blob) {
        // Create form data and upload
        const formData = new FormData();
        formData.append('image', blob, 'cropped_image.jpg');
        formData.append('_token', '{{ csrf_token() }}');
        
        // Upload cropped image
        $.ajax({
            url: '{{ route("admin.products.uploadImage") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#cropAndSave').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
            },
            success: function(response) {
                if (response.success) {
                    // Update hidden input with image path
                    $('#image').val(response.image_path);
                    
                    // Show preview
                    $('#preview-img').attr('src', response.image_url);
                    $('#image-preview').show();
                    
                    // Hide modal
                    $('#imageCropperModal').modal('hide');
                }
            },
            error: function(xhr) {
                $('#imageCropperModal').modal('hide');
                let errorMessage = 'Erro ao carregar imagem';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += ': ' + xhr.responseJSON.message;
                }
                Swal.fire({
                    text: errorMessage,
                    icon: 'error',
                    showClass: {
                        popup: 'animate__animated animate__wobble'
                    }
                });
            },
            complete: function() {
                $('#cropAndSave').prop('disabled', false).html('Cortar e Salvar');
            }
        });
    }

    // Fallback function for older browsers
    function dataURLtoBlob(dataURL) {
        const arr = dataURL.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], { type: mime });
    }

    // Handle remove image
    $(document).on('click', '#remove-image-btn', function() {
        $('#image').val('');
        $('#image-preview').hide();
        $('#image-upload').val('');
    });

    $(document).on("click", ".button-products-toggle-filters", function(e) {
        e.preventDefault();

        $('#content_filters').toggleClass('d-none');
    });

    $(document).on("click", "#button-products-filters", function(e) {
        e.preventDefault();

        loadContentPage();
    });
</script>

<script>
    // Create
    $(document).on("click", ".button-products-create", function(e) {
        e.preventDefault();

        $("#modal-content-products").html('');
        $("#modalProductsLabel").text('Novo Produto');
        var offcanvas = new bootstrap.Offcanvas($('#modalProducts'));
        offcanvas.show();

        var url = `{{ url('/admin/products/create') }}`;
        $.get(url,
            $(this).addClass('modal-scrollfix'),
            function(data) {
                $("#modal-content-products").html(data);
                $(".button-products-save").attr('data-type', 'store');
                initMasks();
            });
    });

    // Edit
    $(document).on("click", ".button-products-edit", function(e) {
        e.preventDefault();

        let product_id = $(this).data('product-id');

        $("#modal-content-products").html('');
        $("#modalProductsLabel").text('Editar Produto');
        var offcanvas = new bootstrap.Offcanvas($('#modalProducts'));
        offcanvas.show();

        var url = `{{ url('/admin/products/${product_id}/edit') }}`;
        $.get(url,
            $(this).addClass('modal-scrollfix'),
            function(data) {
                $("#modal-content-products").html(data);
                $(".button-products-save").attr('data-type', 'edit').attr('data-product-id', product_id);
                initMasks();
            });
    });

    // Save
    $(document).on('click', '.button-products-save', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        let button = $(this);
        let product_id = button.data('product-id');
        var type = button.data('type');

        if (type == 'store') {
            var url = `{{ url('/admin/products/store/') }}`;
        } else {
            if (product_id) {
                var url = `{{ url('/admin/products/${product_id}/update') }}`;
            }
        }

        var form = $('#form-request-products')[0];
        var formData = new FormData(form);
        
        // Convert price from Brazilian format to decimal
        var priceValue = $('#price').val();
        if (priceValue) {
            // Remove currency symbol and convert comma to dot
            var cleanPrice = priceValue.replace(/[^\d,]/g, '').replace(',', '.');
            formData.set('price', cleanPrice);
        }

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
                        $("#modal-content-products").html('');
                        var offcanvas = bootstrap.Offcanvas.getInstance($('#modalProducts'));
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
    $(document).on('click', '.button-products-delete', function(e) {
        e.preventDefault();
        let product_id = $(this).data('product-id');
        let product_name = $(this).data('product-name');

        Swal.fire({
            title: 'Deseja apagar ' + product_name + '?',
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
                    url: `{{ url('/admin/products/${product_id}/delete') }}`,
                    method: 'POST',
                    success: function(data) {
                        $('#row_product_' + product_id).remove();
                        Swal.fire({
                            text: data,
                            icon: 'success',
                            showClass: {
                                popup: 'animate__animated animate__headShake'
                            }
                        }).then((result) => {
                            $('#row_product_' + product_id).remove();
                        });
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
</script>
@endsection