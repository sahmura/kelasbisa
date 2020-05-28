@extends('layouts.master')
@section('title', '- Statistik')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Statistic</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Statistic</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header border-1">
                <h3 class="mb-0">Detail {{ $class->name }}</h3>
            </div>
            <div class="card-body">
                <img src="{{ url('cover/' . $class->cover) }}" alt="{{ $class->name }}" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <h3>Total Pendapatan</h3>
                <p class="lead">Rp{{ $totalTransactionPrices }}</p>
                <h3>Total Pendapatan Bulan Ini</h3>
                <p class="lead">Rp{{ $totalTransactionPricesThisMonth }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-1">
                <h3 class="mb-0">Riwayat Transaksi</h3>
            </div>
            <div class="card-body">
                <div class="row mb-5 d-flex align-items-center">
                    <div class="col-3">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>
                    <div class="col-3">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-md btn-primary" id="btn-filter">Filter</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="tableTransaksi">
                        <thead>
                            <th style="width: 50px;">No</th>
                            <th>Transaction Code</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        refresh_data();
    });

    $('#btn-filter').on('click', function () {
        refresh_data();
    });

    function refresh_data() {
        $('#tableTransaksi').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [1, 'asc'],
            ajax: {
                url: "{{ url('admin/statistic/getTransactionHistory') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: {
                    id: "{{ $class->id }}",
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    class: 'text-center'
                },
                {
                    data: 'transaction_code',
                    orderable: true,
                },
                {
                    data: 'status',
                    orderable: true,
                },
                {
                    data: 'total_prices',
                    orderable: true,
                },
                {
                    data: 'date',
                }
            ],
            language: {
                'paginate': {
                    'previous': '<i class="ni ni-bold-left text-primary"></i>',
                    'next': '<i class="ni ni-bold-right text-primary"></i>'
                }
            }

        });
    }

</script>
@endpush
