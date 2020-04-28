@extends('layouts.master')
@section('title', '- Pengelolaan Transaksi')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Transaction</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Transaction</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card crad-stats shadow">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total transaksi</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $totalTransactions }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="ni ni-book-bookmark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card crad-stats shadow">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Transaksi selesai</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $doneTransactions }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                            <i class="ni ni-circle-08"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card crad-stats shadow">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Transaksi pending</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $pendingTransactions }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                            <i class="ni ni-chart-bar-32"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card crad-stats shadow">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total<br>Prices</h5>
                        <span class="h2 font-weight-bold mb-0">Rp{{ $totalPrices }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-yellow text-white rounded-circle shadow">
                            <i class="ni ni-single-copy-04"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header border-0">
                <h3 class="mb-0">Pengelolaan transaksi</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="row">
                            <div class="form-group col">
                                <select name="status" id="status" class="form-control">
                                    <option value="all">Semua status</option>
                                    @foreach($listStatus as $status)
                                    <option value="{{$status->status}}">{{$status->status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <button class="btn btn-primary btn-md" id="filterData"
                                    onclick="refresh_data()">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light table-flush" id="transactionList">
                        <thead class="text-center thead-light">
                            <th style="width: 30px;">No</th>
                            <th>Nama</th>
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

<div class="modal fade" id="asignModal" tabindex="-1" role="dialog" aria-labelledby="asignModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignModalLabel">Asign User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="asignForm">
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="username">Nama user</label>
                        <input type="text" name="username" id="username" class="form-control" readonly='readonly'>
                    </div>
                    <div class="form-group">
                        <label for="classname">Nama kelas</label>
                        <input type="text" name="classname" id="classname" class="form-control" readonly='readonly'>
                    </div>
                    <div class="form-group">
                        <label for="transaction">Transaksi</label>
                        <input type="text" name="transaction" id="transaction" class="form-control" readonly='readonly'>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-btn">Asign</button>
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

    function refresh_data() {
        table = $('#transactionList').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            ajax: {
                url: "{{ url('admin/transaction/getListData') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                data: {
                    status: $('#status').val(),
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    class: 'text-center'
                },
                {
                    data: 'user.name',
                    orderable: true,
                },
                {
                    data: 'class.name',
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
    }

    $(document).on('click', '.btn-asign', function () {
        var transaction = $(this).data('transaction');
        var username = $(this).data('username');
        var classname = $(this).data('classname');
        var id = $(this).data('id');

        $('#username').val(username);
        $('#transaction').val(transaction);
        $('#classname').val(classname);
        $('#id').val(id);
        $('#asignModal').modal('show');
    });

    $('#save-btn').on('click', function () {
        var data = $('#asignForm').serialize();
        $.ajax({
            url: "{{ url('admin/transaction/asignuser') }}",
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

</script>
@endpush
