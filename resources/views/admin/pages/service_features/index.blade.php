@extends('admin.base')

@section('title', 'Recursos dos Serviços')

@section('content')
<div class="container">
    <div class="py-2 gap-2 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">@yield('title')</h4>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-success button-service-features-create"><i class="fa fa-plus"></i> Adicionar</button>
            <button type="button" class="btn btn-sm btn-primary ms-2 button-service-features-toggle-filters"><i class="fas fa-filter"></i> Filtros</button>
        </div>
    </div>
    <div id="content_filters" class="row d-none">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="title">Título:</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Digite o título">
                            </div>
                            <div class="col-md-4">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1">Habilitado</option>
                                    <option value="2">Desabilitado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="button" id="button-service-features-filters" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Filtrar</button>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="modalServiceFeatures" aria-labelledby="modalServiceFeaturesLabel">
    <div class="offcanvas-header">
        <h5 id="modalServiceFeaturesLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div> <!-- end offcanvas-header-->

    <div class="offcanvas-body" id="modal-content-service-features">
    </div> <!-- end offcanvas-body-->
</div> <!-- end offcanvas-->
@endsection

@section('pageCSS')
@endsection

@section('pageJS')
<script>
    $(document).ready(function() {
        loadContentPage();
    });

    function loadContentPage() {
        $("#content-load-page").html('');
        var url = `{{ url('/admin/service-features/load') }}`;
        var filters = $('#filter-form').serialize();

        $.get(url + '?' + filters, function(data) {
            $("#content-load-page").html(data);
        });
    }

    $(document).on("click", ".button-service-features-toggle-filters", function(e) {
        e.preventDefault();
        $('#content_filters').toggleClass('d-none');
    });

    $(document).on("click", "#button-service-features-filters", function(e) {
        e.preventDefault();
        loadContentPage();
    });
</script>

<script>
    // Create
    $(document).on("click", ".button-service-features-create", function(e) {
        e.preventDefault();

        $("#modal-content-service-features").html('');
        $("#modalServiceFeaturesLabel").text('Novo Recurso do Serviço');
        var offcanvas = new bootstrap.Offcanvas($('#modalServiceFeatures'));
        offcanvas.show();

        var url = `{{ url('/admin/service-features/create') }}`;
        $.get(url,
            $(this).addClass('modal-scrollfix'),
            function(data) {
                $("#modal-content-service-features").html(data);
                $(".button-service-features-save").attr('data-type', 'store');
            });
    });

    // Edit
    $(document).on("click", ".button-service-features-edit", function(e) {
        e.preventDefault();

        let service_feature_id = $(this).data('service-feature-id');

        $("#modal-content-service-features").html('');
        $("#modalServiceFeaturesLabel").text('Editar Recurso do Serviço');
        var offcanvas = new bootstrap.Offcanvas($('#modalServiceFeatures'));
        offcanvas.show();

        var url = `{{ url('/admin/service-features/${service_feature_id}/edit') }}`;
        $.get(url,
            $(this).addClass('modal-scrollfix'),
            function(data) {
                $("#modal-content-service-features").html(data);
                $(".button-service-features-save").attr('data-type', 'edit').attr('data-service-feature-id', service_feature_id);
            });
    });

    // Save
    $(document).on('click', '.button-service-features-save', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        let button = $(this);
        let service_feature_id = button.data('service-feature-id');
        var type = button.data('type');

        if (type == 'store') {
            var url = `{{ url('/admin/service-features/store/') }}`;
        } else {
            if (service_feature_id) {
                var url = `{{ url('/admin/service-features/${service_feature_id}/update') }}`;
            }
        }

        var form = $('#form-request-service-features')[0];
        var formData = new FormData(form);

        $.ajax({
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            method: 'POST',
            beforeSend: function() {
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
                        $("#modal-content-service-features").html('');
                        var offcanvas = bootstrap.Offcanvas.getInstance($('#modalServiceFeatures'));
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
    $(document).on('click', '.button-service-features-delete', function(e) {
        e.preventDefault();
        let service_feature_id = $(this).data('service-feature-id');
        let service_feature_title = $(this).data('service-feature-title');

        Swal.fire({
            title: 'Deseja apagar ' + service_feature_title + '?',
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
                    url: `{{ url('/admin/service-features/${service_feature_id}/delete') }}`,
                    method: 'POST',
                    success: function(data) {
                        $('#row_service_feature_' + service_feature_id).remove();
                        Swal.fire({
                            text: data,
                            icon: 'success',
                            showClass: {
                                popup: 'animate__animated animate__headShake'
                            }
                        }).then((result) => {
                            $('#row_service_feature_' + service_feature_id).remove();
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


