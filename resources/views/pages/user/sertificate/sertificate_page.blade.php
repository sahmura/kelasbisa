@extends('layouts.master')
@section('title', '- Daftar Kelas')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-google-pages mr-2"></i>Cetak Sertifikat</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('user') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cetak Sertifikat</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-8 align-self-center">
                    <h4 class="mt-0 header-title">Cetak Sertifikat</h4>
                    <p>Pastikan kamu sudah menyelesaikan semua materi</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-light table-flush" id="certificateList">
                        <thead class="text-center thead-light">
                            <th style="width: 30px;">No</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th style="width: 50px;"><i class="ni ni-ungroup"></i></th>
                        </thead>
                        <tbody class="list"></tbody>
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
        $('#certificateList').DataTable({
            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            ajax: {
                url: "{{ url('user/certificate/getListData') }}",
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
                    data: 'class_name',
                    orderable: true,
                },
                {
                    data: 'status',
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

    $(document).on('click', '.downloadSertificate', function() {
        var class_id = $(this).data('classid');
        window.location.href = "{{ url('user/certificate/get') }}" + "?class_id=" + class_id +
            '&template=basic_template';
    });
</script>
@endpush