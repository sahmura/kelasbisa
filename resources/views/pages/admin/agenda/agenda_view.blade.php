@extends('layouts.master')
@section('title', '- Pengelolaan Kategori')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Agenda</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Agenda</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-6 col-5 text-right">
        <button class="btn btn-md btn-neutral" id="addNewButton">New</button>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h3 class="mb-0">Agenda hari ini</h3>
            </div>
            <div class="card-body">
                @foreach($todayAgendas as $today)
                <p>{{ $today->name }}</p>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h3 class="mb-0">Agenda selanjutnya</h3>
            </div>
            <div class="card-body">
                @foreach($nextAgendas as $next)
                <p>({{\Carbon\Carbon::parse($next->target)->locale('id')->isoFormat('Do MMMM YYYY')}})
                    {{ $next->name }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-0">
                <h3 class="mb-0">Pengelolaan agenda</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-light table-flush" id="categoryList">
                        <thead class="text-center thead-light">
                            <th style="width: 30px;">No</th>
                            <th>Nama</th>
                            <th style="width: 140px;">Target</th>
                            <th style="width: 50px;"><i class="ni ni-ungroup"></i></th>
                        </thead>
                        <tbody class="list"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agendaModal" tabindex="-1" role="dialog" aria-labelledby="agendaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agendaModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="dataForm">
                    @csrf
                    <input type="hidden" name="id" value="" id="id">
                    <div class="form-group">
                        <label for="name">Nama agenda</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama agenda"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <input type="text" name="description" id="description" class="form-control"
                            placeholder="Deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="target">Target</label>
                        <input type="date" class="form-control" name="target" id="target" placeholder="Target" required>
                    </div>
                    <div class="form-group" id="resultAgenda">
                        <label for="result">Hasil</label>
                        <textarea name="result" id="resut" class="form-control" placeholder="Hasil Agenda"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn" id="save-btn">Tambah data</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="previewAgendaModal" tabindex="-1" role="dialog" aria-labelledby="previewAgendaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewAgendaModalLabel">Detail Agenda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 id="prevNamaAgenda"></h1>
                <h3 id="prevTargetAgenda"></h3>
                <p id="prevDescAgenda"></p>
                <p><b>Hasil Agenda</b></p>
                <hr>
                <p id="prevResultAgenda"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        $('#categoryList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/agenda/getListData') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    class: 'text-center'
                },
                {
                    data: 'name',
                    orderable: true,
                },
                {
                    data: 'target',
                    orderable: true,
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    class: 'text-center'
                }
            ],
            language: {
                'paginate': {
                    'previous': '<i class="ni ni-bold-left text-primary"></i>',
                    'next': '<i class="ni ni-bold-right text-primary"></i>'
                }
            }

        });
    });

    $('#addNewButton').on('click', function () {
        $('#dataForm')[0].reset();
        $('.modal-title').html('Tambah kategori baru');
        $('#save-btn').addClass('btn-success');
        $('#save-btn').html('Tambah data');
        $('#resultAgenda').hide();
        $('#agendaModal').modal('show');
    });

    $('#save-btn').on('click', function () {
        $('#loaderSpin').fadeIn('slow');
        var data = $('#dataForm').serialize();
        if ($('#id').val() == '') {
            var url = "{{ url('admin/agenda/add') }}";
        } else {
            var url = "{{ url('admin/agenda/edit') }}";
        }
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: data,
            success: function (response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        $('#agendaModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        $('#agendaModal').modal('hide');
                        location.reload();
                    });
                }
            }
        });
    });

    $(document).on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var description = $(this).data('description');
        var target = $(this).data('target');
        var result = $(this).data('result');

        $('#resultAgenda').show();
        $('#dataForm')[0].reset();
        $('#id').val(id);
        $('#name').val(name);
        $('#description').val(description);
        $('#target').val(target);
        $('#result').val(result);

        $('.modal-title').html('Sunting data')
        $('#save-btn').addClass('btn-warning');
        $('#save-btn').html('Simpan data');
        $('#agendaModal').modal('show');
    });

    $(document).on('click', '.btn-detail', function () {
        var name = $(this).data('name');
        var description = $(this).data('description');
        var target = $(this).data('target');
        var result = $(this).data('result');

        $('#prevNamaAgenda').text(name);
        $('#prevTargetAgenda').text(target);
        $('#prevDescAgenda').text(description);
        $('#prevResultAgenda').text(result);
        $('#previewAgendaModal').modal('show');
    });

    $(document).on('click', '.btn-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF3636',
            cancelButtonColor: '#888888',
            confirmButtonText: 'Ya, hapus',

        }).then((Confirm) => {
            if (Confirm.value) {
                $('#loaderSpin').fadeIn('slow');
                $.ajax({
                    url: "{{ url('admin/agenda/delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'delete',
                    data: {
                        id: id
                    },
                    success: function (response) {
                        $('#loaderSpin').fadeOut('slow');
                        if (response.status) {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'success'
                            }).then((Confirm) => {
                                $('#agendaModal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'error'
                            }).then((Confirm) => {
                                $('#agendaModal').modal('hide');
                                location.reload();
                            });
                        }
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        $('#result').summernote();
    });

</script>
@endpush
