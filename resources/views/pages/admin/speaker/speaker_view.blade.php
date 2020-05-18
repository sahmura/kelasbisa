@extends('layouts.master')
@section('title', '- Pengelolaan Kategori')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Speaker</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Speaker</li>
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
                <h3 class="mb-0">Pengelolaan pembicara</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-light table-flush" id="speakerList">
                        <thead class="text-center thead-light">
                            <th style="width: 30px;">No</th>
                            <th>Nama</th>
                            <th style="width: 140px;">Skill</th>
                            <th style="width: 50px;"><i class="ni ni-ungroup"></i></th>
                        </thead>
                        <tbody class="list"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="speakerModal" tabindex="-1" role="dialog" aria-labelledby="speakerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="speakerModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="dataForm">
                    @csrf
                    <input type="hidden" name="id" value="" id="id">
                    <div class="form-group">
                        <label for="name">Nama pembicara</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama agenda"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="skill">Skill</label>
                        <input type="text" name="skill" id="skill" class="form-control" placeholder="Keahlian pembicara"
                            required>
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
<div class="modal fade" id="signatureModal" tabindex="-1" role="dialog" aria-labelledby="signatureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signatureModalLabel">Tambahkan Signature</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/speaker/addSignature') }}" method="post" id="signatureForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="" id="idSignature">
                    <input type="hidden" name="name" value="" id="nameSignature">
                    <div class="form-group">
                        <div id="imgSignature">
                            <img src="" alt="" id="signatureImg" class="img-fluid">
                        </div>
                        <label for="signature">Signature</label>
                        <input type="file" name="signature" id="signature" class="form-control"
                            placeholder="Upload tanda tangan">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="signatureForm">Tambah data</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
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
    });

    $(document).ready(function () {
        $('#speakerList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/speaker/getListData') }}",
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
                    data: 'skill',
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
        $('.modal-title').html('Tambah Pembicara baru');
        $('#save-btn').addClass('btn-success');
        $('#save-btn').html('Tambah data');
        $('#imgSignature').hide();
        $('#speakerModal').modal('show');
    });

    $('#save-btn').on('click', function () {
        var data = $('#dataForm').serialize();
        console.log(data);
        if ($('#id').val() == '') {
            var url = "{{ url('admin/speaker/add') }}";
        } else {
            var url = "{{ url('admin/speaker/edit') }}";
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
                    }).then((Confirm) => {
                        $('#speakerModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        $('#speakerModal').modal('hide');
                        location.reload();
                    });
                }
            }
        });
    });

    $(document).on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var skill = $(this).data('skill');
        var signature = $(this).data('signature');

        $('#resultAgenda').show();
        $('#dataForm')[0].reset();
        $('#id').val(id);
        $('#name').val(name);
        $('#skill').val(skill);

        $('.modal-title').html('Sunting data')
        $('#save-btn').addClass('btn-warning');
        $('#save-btn').html('Simpan data');
        $('#speakerModal').modal('show');
    });

    $(document).on('click', '.btn-signature', function () {
        $('#signatureImg').removeAttr('src');
        $('#signatureForm')[0].reset();
        var id = $(this).data('id');
        var name = $(this).data('name');
        var signature = $(this).data('signature');

        if (signature != '') {
            $('#signatureImg').attr('src', "{{ url('assets/signature') }}" + '/' + signature);
        }

        $('#idSignature').val(id);
        $('#nameSignature').val(name);
        $('#signatureModal').modal('show');
    });

</script>
@endpush
