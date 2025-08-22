@extends('admin.base')

@section('title', 'Slider')

@section('content')
<div class="container">
    <div class="py-2 gap-2 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">@yield('title')</h4>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-success button-sliders-create"><i class="fa fa-plus"></i> Adicionar</button>
            <button type="button" class="btn btn-sm btn-primary ms-2 button-sliders-toggle-filters"><i class="fas fa-filter"></i> Filtros</button>
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
                                <button type="button" id="button-sliders-filters" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Filtrar</button>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="modalSliders" aria-labelledby="modalSlidersLabel">
    <div class="offcanvas-header">
        <h5 id="modalSlidersLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div> <!-- end offcanvas-header-->

    <div class="offcanvas-body" id="modal-content-sliders">
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
<!-- Flatpickr Timepicker Plugin js -->
<script src="{{ asset('/tpl_dashboard/vendor/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('/tpl_dashboard/vendor/flatpickr/l10n/pt.js') }}"></script>

<!-- Cropper.js JS -->
<script src="{{ asset('/plugins/croppperjs/cropper.min.js') }}"></script>

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
        var url = `{{ url('/admin/sliders/load') }}`;
        var filters = $('#filter-form').serialize();
        if (page > 1) { filters += '&page=' + page; }

        $.get(url + '?' + filters, function(data) {
            $("#content-load-page").html(data);
            $(document).off("click", ".pagination-link");
            $(document).on("click", ".pagination-link", function(e) {
                e.preventDefault();
                var pageNum = $(this).data('page');
                loadContentPage(pageNum);
            });
        });
    }

    function initMasks() {
        $(".flatpickr-datetime").flatpickr({
            "enableTime": true,
            "dateFormat": "d/m/Y H:i",
            "locale": "pt",
            "firstDayOfWeek": 1,
        });
        initImageUpload();
    }

    let cropper = null;
    let currentImageFile = null;
    let currentImageSrc = null;

    function initImageUpload() {
        $('#image-upload').hide();

        $('#upload-image-btn').off('click').on('click', function() {
            $('#image-upload').click();
        });

        $('#image-upload').off('change').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                currentImageFile = file;

                if (file.size > 20 * 1024 * 1024) {
                    Swal.fire({
                        text: 'A imagem é muito grande. Por favor, selecione uma imagem menor que 20MB.',
                        icon: 'warning',
                        showClass: {
                            popup: 'animate__animated animate__wobble'
                        }
                    });
                    $(this).val('');
                    return;
                }

                processImageForCropper(file);
            }
        });

        $('#imageCropperModal').off('hidden.bs.modal').on('hidden.bs.modal', function() {
            destroyCropper();
        });
    }

    function processImageForCropper(file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                // Para imagens muito grandes, redimensionar apenas se necessário
                let { width, height } = img;
                const targetAspectRatio = 16 / 9;
                const imageAspectRatio = width / height;

                // Manter qualidade original se a imagem não for muito grande
                const maxSize = 2560; // Aumentado para 2560px para manter qualidade
                if (width > maxSize || height > maxSize) {
                    if (imageAspectRatio > targetAspectRatio) {
                        width = maxSize;
                        height = width / imageAspectRatio;
                    } else {
                        height = maxSize;
                        width = height * imageAspectRatio;
                    }
                }

                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                canvas.width = width;
                canvas.height = height;
                
                // Melhorar qualidade do canvas
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                
                ctx.drawImage(img, 0, 0, width, height);

                currentImageSrc = canvas.toDataURL('image/jpeg', 0.95); // Usar alta qualidade
                showCropperModal();
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }

    function showCropperModal() {
        destroyCropper();
        $('#cropperImage').attr('src', currentImageSrc);
        $('#imageCropperModal').modal('show');

        setTimeout(function() {
            initializeCropper();
        }, 300);
    }

    function initializeCropper() {
        const image = document.getElementById('cropperImage');
        if (!image || !image.src) return;

        cropper = new Cropper(image, {
            aspectRatio: 16 / 9,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1.0,
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
                const containerData = cropper.getContainerData();
                const imageData = cropper.getImageData();

                const cropBoxWidth = Math.min(imageData.width, containerData.width);
                const cropBoxHeight = cropBoxWidth / (16 / 9);

                // Ensure crop box fits within image dimensions
                let finalWidth = cropBoxWidth;
                let finalHeight = cropBoxHeight;

                if (finalHeight > imageData.height) {
                    finalHeight = imageData.height;
                    finalWidth = finalHeight * (16 / 9);
                }

                const left = (imageData.width - finalWidth) / 2;
                const top = (imageData.height - finalHeight) / 2;

                cropper.setCropBoxData({
                    left: left,
                    top: top,
                    width: finalWidth,
                    height: finalHeight
                });
            }
        });
    }

    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function reinitializeCropper() {
        destroyCropper();
        setTimeout(function() {
            initializeCropper();
        }, 100);
    }

    $('#cropAndSave').off('click').on('click', function() {
        if (cropper) {
            try {
                const canvas = cropper.getCroppedCanvas({
                    width: 1920, // Aumentado para 1920px para manter qualidade original
                    height: 1080, // Aumentado para 1080px (1920 / 16 * 9)
                    minWidth: 100,
                    minHeight: 100,
                    maxWidth: 1920,
                    maxHeight: 1080,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                if (!canvas) {
                    throw new Error('canvas_error');
                }

                if (canvas.width === 0 || canvas.height === 0) {
                    throw new Error('canvas_error');
                }

                if (!canvas.toBlob) {
                    const dataURL = canvas.toDataURL('image/jpeg', 0.95); // Aumentado de 0.85 para 0.95
                    if (!dataURL || dataURL === 'data:,') {
                        throw new Error('canvas_error');
                    }
                    const blob = dataURLtoBlob(dataURL);
                    uploadCroppedImage(blob);
                } else {
                    canvas.toBlob(function(blob) {
                        if (!blob || blob.size === 0) {
                            reinitializeCropper();
                            return;
                        }
                        uploadCroppedImage(blob);
                    }, 'image/jpeg', 0.95); // Aumentado de 0.85 para 0.95
                }
            } catch (error) {
                console.error('Erro no cropper:', error);

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

    function uploadCroppedImage(blob) {
        const formData = new FormData();
        formData.append('image', blob, 'cropped_image.jpg');
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("admin.sliders.uploadImage") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#cropAndSave').prop('disabled', true).html('<i class=\"fa fa-spinner fa-spin\"></i> Salvando...');
            },
            success: function(response) {
                if (response.success) {
                    $('#image').val(response.image_path);
                    $('#preview-img').attr('src', response.image_url);
                    $('#image-preview').show();
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

    $(document).on('click', '#remove-image-btn', function() {
        $('#image').val('');
        $('#image-preview').hide();
        $('#image-upload').val('');
    });

    $(document).on("click", ".button-sliders-toggle-filters", function(e) {
        e.preventDefault();

        $('#content_filters').toggleClass('d-none');
    });

    $(document).on("click", "#button-sliders-filters", function(e) {
        e.preventDefault();

        loadContentPage();
    });
</script>

<script>
    // Create
    $(document).on("click", ".button-sliders-create", function(e) {
        e.preventDefault();

        $("#modal-content-sliders").html('');
        $("#modalSlidersLabel").text('Nova Slider');
        var offcanvas = new bootstrap.Offcanvas($('#modalSliders'));
        offcanvas.show();

        var url = `{{ url('/admin/sliders/create') }}`;
        $.get(url,
            $(this).addClass('modal-scrollfix'),
            function(data) {
                $("#modal-content-sliders").html(data);
                $(".button-sliders-save").attr('data-type', 'store');
                initMasks();
            });
    });

    // Edit
    $(document).on("click", ".button-sliders-edit", function(e) {
        e.preventDefault();

        let slider_id = $(this).data('slider-id');

        $("#modal-content-sliders").html('');
        $("#modalSlidersLabel").text('Editar Slider');
        var offcanvas = new bootstrap.Offcanvas($('#modalSliders'));
        offcanvas.show();

        var url = `{{ url('/admin/sliders/${slider_id}/edit') }}`;
        $.get(url,
            $(this).addClass('modal-scrollfix'),
            function(data) {
                $("#modal-content-sliders").html(data);
                $(".button-sliders-save").attr('data-type', 'edit').attr('data-slider-id', slider_id);
                initMasks();
            });
    });

    // Save
    $(document).on('click', '.button-sliders-save', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        let button = $(this);
        let slider_id = button.data('slider-id');
        var type = button.data('type');

        if (type == 'store') {
            var url = `{{ url('/admin/sliders/store/') }}`;
        } else {
            if (slider_id) {
                var url = `{{ url('/admin/sliders/${slider_id}/update') }}`;
            }
        }

        var form = $('#form-request-sliders')[0];
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
                        $("#modal-content-sliders").html('');
                        var offcanvas = bootstrap.Offcanvas.getInstance($('#modalSliders'));
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
    $(document).on('click', '.button-sliders-delete', function(e) {
        e.preventDefault();
        let slider_id = $(this).data('slider-id');
        let slider_name = $(this).data('slider-name');

        Swal.fire({
            title: 'Deseja apagar ' + slider_name + '?',
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
                    url: `{{ url('/admin/sliders/${slider_id}/delete') }}`,
                    method: 'POST',
                    success: function(data) {
                        $('#row_slider_' + slider_id).remove();
                        Swal.fire({
                            text: data,
                            icon: 'success',
                            showClass: {
                                popup: 'animate__animated animate__headShake'
                            }
                        }).then((result) => {
                            $('#row_slider_' + slider_id).remove();
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