@extends('layouts.master')
@section('title', '- Pengelolaan Promo Code')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Kode Promo</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kode Promo</li>
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
                <h3 class="mb-0">Pengelolaan Kode Promo</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-light table-flush" id="couponList">
                        <thead class="text-center thead-light">
                            <th style="width: 30px;">No</th>
                            <th>Kelas</th>
                            <th>Kode</th>
                            <th>Discount</th>
                            <th style="width: 50px;"><i class="ni ni-ungroup"></i></th>
                        </thead>
                        <tbody class="list"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="couponModal" tabindex="-1" role="dialog" aria-labelledby="couponModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="couponModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="dataForm">
                    @csrf
                    <input type="hidden" name="id" value="" id="id">
                    <div class="form-group">
                        <label for="coupon">Kode</label>
                        <input type="text" name="coupon" id="coupon" class="form-control" placeholder="Kode promo"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="classid">Kelas</label>
                        <select name="class_id" id="classid" class="custom-select" required>
                            <option value="0">Pilih kelas</option>
                            @foreach($listClasses as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount</label>
                        <input type="number" name="discount" id="discount" class="form-control"
                            placeholder="Potongan harga" required>
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
        $('#couponList').DataTable({
            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            ajax: {
                url: "{{ url('admin/coupon/getListData') }}",
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
                    data: 'class.name',
                    orderable: true,
                },
                {
                    data: 'coupon',
                    orderable: true,
                },
                {
                    data: 'discount',
                    orderable: false,
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
        $('.modal-title').html('Tambah kode promo baru');
        $('#save-btn').addClass('btn-success');
        $('#save-btn').html('Tambah data');
        $('#couponModal').modal('show');
    });

    $('#save-btn').on('click', function () {
        $('#loaderSpin').fadeIn('slow');
        var data = $('#dataForm').serialize();
        if ($('#id').val() == '') {
            var url = "{{ url('admin/coupon/add') }}";
        } else {
            var url = "{{ url('admin/coupon/edit') }}";
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
                        $('#couponModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        $('#couponModal').modal('hide');
                        location.reload();
                    });
                }
            }
        });
    });

    $(document).on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        var coupon = $(this).data('coupon');
        var classid = $(this).data('classid');
        var disc = $(this).data('disc');
        $('#dataForm')[0].reset();
        $('#id').val(id);
        $('#coupon').val(coupon);
        $('#classid').val(classid);
        $('#discount').val(disc);

        $('.modal-title').html('Sunting data')
        $('#save-btn').addClass('btn-warning');
        $('#save-btn').html('Simpan data');
        $('#couponModal').modal('show');
    });

    $(document).on('click', '.btn-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Kode tidak dapat digunakan kembali',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF3636',
            cancelButtonColor: '#888888',
            confirmButtonText: 'Ya, hapus',

        }).then((Confirm) => {
            if (Confirm.value) {
                $('#loaderSpin').fadeIn('slow');
                $.ajax({
                    url: "{{ url('admin/coupon/delete') }}",
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
                                $('#couponModal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'error'
                            }).then((Confirm) => {
                                $('#couponModal').modal('hide');
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
