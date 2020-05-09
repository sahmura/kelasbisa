@extends('layouts.master')
@section('title', '- Pengelolaan User')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">User</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-0">
                <h3 class="mb-0">Pengelolaan user</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-light table-flush" id="userList">
                        <thead class="text-center thead-light">
                            <th style="width: 30px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th style="width: 50px;"><i class="ni ni-ungroup"></i></th>
                        </thead>
                        <tbody class="list"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="asignModal" tabindex="-1" role="dialog" aria-labelledby="asignModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="dataForm">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name">Nama user</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama user" required
                            readonly='readonly'>
                    </div>
                    <div class="form-group">
                        <label for="description">Pilih kelas</label>
                        <div class="select2-wrapper">
                            <select name="class_id" id="class_id" class="custom-select">
                                <option></option>
                                @foreach($classes as $class)
                                <option value="{{$class->id}}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
@endsection
@push('css')
<link href="{{ url('assets/css/select2-bootstrap.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#class_id').select2({
            placeholder: "Pilih kelas",
        });
        $('#userList').DataTable({
            processing: true,
            serverSide: true,
            order: [1, 'desc'],
            ajax: {
                url: "{{ url('admin/user/getListUser') }}",
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
                    data: 'email',
                    orderable: true,
                },
                {
                    data: 'status',
                    orderable: true,
                },
                {
                    data: 'role',
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

    $('#save-btn').on('click', function () {
        var data = $('#dataForm').serialize();
        $.ajax({
            url: "{{ url('admin/asignclass') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: data,
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    });
                    $('#categoryModal').modal('hide');
                    location.reload();
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    });
                    $('#categoryModal').modal('hide');
                    location.reload();
                }
            }
        });
    });

    $(document).on('click', '.btn-asign', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');

        $('#dataForm')[0].reset();
        $('#user_id').val(id);
        $('#name').val(name);

        $('.modal-title').html('Asign User')
        $('#save-btn').addClass('btn-warning');
        $('#save-btn').html('Simpan data');
        $('#asignModal').modal('show');
    });

    $(document).on('click', '.btn-change-permission', function () {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ url('admin/changeUserPermission') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id
            },
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        if (Confirm.value) {
                            location.reload();
                        }
                    })
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    });
                }
            }

        })
    });

    $(document).on('click', '.btn-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Jika ada kelas, maka akan dimasukkan ke dalam kategori Tidak berkategori',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF3636',
            cancelButtonColor: '#888888',
            confirmButtonText: 'Ya, hapus',

        }).then((Confirm) => {
            if (Confirm.value) {
                $.ajax({
                    url: "{{ url('admin/category/delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'delete',
                    data: {
                        id: id
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'success'
                            });
                            $('#categoryModal').modal('hide');
                            location.reload();
                        } else {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'error'
                            });
                            $('#categoryModal').modal('hide');
                            location.reload();
                        }
                    }
                });
            }
        });
    });

</script>
@endpush
