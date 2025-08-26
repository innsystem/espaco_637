@extends('admin.base')

@section('title', 'Pontos da Filosofia')

@section('content')
<div class="container">
    <div class="py-2 gap-2 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">@yield('title')</h4>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-success button-philosophy-points-create"><i class="fa fa-plus"></i> Adicionar</button>
            <button type="button" class="btn btn-sm btn-primary ms-2 button-philosophy-points-toggle-filters"><i class="fas fa-filter"></i> Filtros</button>
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
                                <button type="button" id="button-philosophy-points-filters" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Filtrar</button>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="modalPhilosophyPoints" aria-labelledby="modalPhilosophyPointsLabel">
    <div class="offcanvas-header">
        <h5 id="modalPhilosophyPointsLabel"></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div> <!-- end offcanvas-header-->

    <div class="offcanvas-body" id="modal-content-philosophy-points">
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
        var url = `{{ url('/admin/philosophy-points/load') }}`;
        var filters = $('#filter-form').serialize();

        $.get(url + '?' + filters, function(data) {
            $("#content-load-page").html(data);
        });
    }

    $(document).on("click", ".button-philosophy-points-toggle-filters", function(e) {
        e.preventDefault();
        $('#content_filters').toggleClass('d-none');
    });

    $(document).on("click", "#button-philosophy-points-filters", function(e) {
        e.preventDefault();
        loadContentPage();
    });
</script>

<script>
    // Create
    $(document).on("click", ".button-philosophy-points-create", function(e) {
        e.preventDefault();

        $("#modal-content-philosophy-points").html('');
        $("#modalPhilosophyPointsLabel").text('Novo Ponto da Filosofia');
        var offcanvas = new bootstrap.Offcanvas($('#modalPhilosophyPoints'));
        offcanvas.show();

        var url = `{{ url('/admin/philosophy-points/create') }}`;
        $.get(url,
            $(this).addClass('modal-scrollfix'),
            function(data) {
                $("#modal-content-philosophy-points").html(data);
                $(".button-philosophy-points-save").attr('data-type', 'store');
            });
    });

    // Edit
    $(document).on("click", ".button-philosophy-points-edit", function(e) {
        e.preventDefault();

        let philosophy_point_id = $(this).data('philosophy-point-id');

        $("#modal-content-philosophy-points").html('');
        $("#modalPhilosophyPointsLabel").text('Editar Ponto da Filosofia');
        var offcanvas = new bootstrap.Offcanvas($('#modalPhilosophyPoints'));
        offcanvas.show();

        var url = `{{ url('/admin/philosophy-points/${philosophy_point_id}/edit') }}`;
        $.get(url,
            $(this).addClass('modal-scrollfix'),
            function(data) {
                $("#modal-content-philosophy-points").html(data);
                $(".button-philosophy-points-save").attr('data-type', 'edit').attr('data-philosophy-point-id', philosophy_point_id);
            });
    });

    // Save
    $(document).on('click', '.button-philosophy-points-save', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        let button = $(this);
        let philosophy_point_id = button.data('philosophy-point-id');
        var type = button.data('type');

        if (type == 'store') {
            var url = `{{ url('/admin/philosophy-points/store/') }}`;
        } else {
            if (philosophy_point_id) {
                var url = `{{ url('/admin/philosophy-points/${philosophy_point_id}/update') }}`;
            }
        }

        var form = $('#form-request-philosophy-points')[0];
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
                        $("#modal-content-philosophy-points").html('');
                        var offcanvas = bootstrap.Offcanvas.getInstance($('#modalPhilosophyPoints'));
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
    $(document).on('click', '.button-philosophy-points-delete', function(e) {
        e.preventDefault();
        let philosophy_point_id = $(this).data('philosophy-point-id');
        let philosophy_point_title = $(this).data('philosophy-point-title');

        Swal.fire({
            title: 'Deseja apagar ' + philosophy_point_title + '?',
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
                    url: `{{ url('/admin/philosophy-points/${philosophy_point_id}/delete') }}`,
                    method: 'POST',
                    success: function(data) {
                        $('#row_philosophy_point_' + philosophy_point_id).remove();
                        Swal.fire({
                            text: data,
                            icon: 'success',
                            showClass: {
                                popup: 'animate__animated animate__headShake'
                            }
                        }).then((result) => {
                            $('#row_philosophy_point_' + philosophy_point_id).remove();
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


