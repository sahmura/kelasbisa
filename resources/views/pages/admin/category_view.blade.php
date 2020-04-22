@extends('layouts.master')
@section('title', '- Pengelolaan Kategori')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Category</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category</li>
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
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-0">
                <h3 class="mb-0">Pengelolaan kategori</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-light table-flush" id="categoryList">
                        <thead class="text-center thead-light">
                            <th style="width: 30px;">No</th>
                            <th>Nama</th>
                            <th style="width: 50px;"><i class="ni ni-ungroup"></i></th>
                        </thead>
                        <tbody class="list"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="dataForm">
                    @csrf
                    <input type="hidden" name="id" value="" id="id">
                    <div class="form-group">
                        <label for="name">Nama kategori</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama kategori"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <input type="text" name="description" id="description" class="form-control"
                            placeholder="Deskripsi" required>
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
@push('js')
<script>
    $(document).ready(function () {
        $('#categoryList').DataTable({
            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            ajax: {
                url: "{{ url('admin/category/getListData') }}",
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
        $('#categoryModal').modal('show');
    });

    $('#save-btn').on('click', function () {
        var data = $('#dataForm').serialize();
        if ($('#id').val() == '') {
            var url = "{{ url('admin/category/add') }}";
        } else {
            var url = "{{ url('admin/category/edit') }}";
        }
        $.ajax({
            url: url,
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

    $(document).on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var description = $(this).data('description');

        $('#dataForm')[0].reset();
        $('#id').val(id);
        $('#name').val(name);
        $('#description').val(description);

        $('.modal-title').html('Sunting data')
        $('#save-btn').addClass('btn-warning');
        $('#save-btn').html('Simpan data');
        $('#categoryModal').modal('show');
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
