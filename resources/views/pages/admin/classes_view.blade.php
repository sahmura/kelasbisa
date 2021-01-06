@extends('layouts.master')
@section('title', '- Pengelolaan Kelas')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right align-item-center mt-2">
                <button class="btn btn-md btn-info px-5" id="addNewButton">Tambah kelas</button>
            </div>
            <h4 class="page-title mb-2"><i class="mdi mdi-google-pages mr-2"></i>Kelas</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Class</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-0">
                <h3 class="mb-0">Pengelolaan kelas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="classList">
                        <thead class="text-center">
                            <th style="width: 30px;">No</th>
                            <th>Nama kelas</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th style="width: 50px;"><i class="ni ni-settings-gear-65"></i></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    $(document).ready(function() {
        @if(session('success'))
        Swal.fire({
            title: "{{ session('success') }}",
            icon: 'success'
        });
        @endif

        @if(session('error'))
        Swal.fire({
            title: "{{ session('error') }}",
            icon: 'error'
        });
        @endif

        $('#classList').DataTable({
            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            ajax: {
                url: "{{ url('admin/class/getListData') }}",
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
                    data: 'category.name',
                    defaultContent: 'Tidak berkategori'
                },
                {
                    data: 'type_class',
                },
                {
                    data: 'status',
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

    $('#addNewButton').on('click', function() {
        window.location.href = "{{ url('admin/class/new') }}";
    });

    $('#save-btn').on('click', function() {
        $('#loaderSpin').fadeIn('slow');
        var data = $('#dataForm').serialize();
        if ($('#id').val() == '') {
            var url = "{{ url('admin/class/add') }}";
        } else {
            var url = "{{ url('admin/class/edit') }}";
        }
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: data,
            success: function(response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        $('#classModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        $('#classModal').modal('hide');
                        location.reload();
                    });
                }
            }
        });
    });

    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        window.location.href = "{{ url('admin/class/') }}" + '/' + id + '/edit';
    });

    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Jika ada chapter, semua chapter akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF3636',
            cancelButtonColor: '#888888',
            confirmButtonText: 'Ya, hapus',

        }).then((Confirm) => {
            if (Confirm) {
                $('#loaderSpin').fadeIn('slow');
                $.ajax({
                    url: "{{ url('admin/class/delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'delete',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $('#loaderSpin').fadeOut('slow');
                        if (response.status) {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'success'
                            }).then((Confirm) => {
                                $('#classModal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'error'
                            }).then((Confirm) => {
                                $('#classModal').modal('hide');
                                location.reload();
                            });
                        }
                    }
                });
            }
        });
    });
</script>
@endpush