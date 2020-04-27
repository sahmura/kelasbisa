@extends('layouts.master')
@section('title', '- Admin area')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Admin</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
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
                        <h5 class="card-title text-uppercase text-muted mb-0">Total kelas</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $data['totalClasses'] }}</span>
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
                        <h5 class="card-title text-uppercase text-muted mb-0">Total pengguna</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $data['totalUsers'] }}</span>
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
                        <h5 class="card-title text-uppercase text-muted mb-0">Total transaksi</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $data['totalTransactions'] }}</span>
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
                        <h5 class="card-title text-uppercase text-muted mb-0">Total chapter</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $data['totalChapters'] }}</span>
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
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-green">
                <h3 class="text-white">Pengguna baru</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($data['newUsers'] as $user)
                    <li class="list-group-item d-flex align-items-center">
                        <div class="float-left mr-3">
                            @if($user->profilpic == '')
                            <img src="{{ url('assets/image/userpic.svg') }}" class="rounded-circle" width="40"
                                height="auto">
                            @else
                            <img src="{{ url('assets/profilpic/' . $user->profilpic) }}" class="rounded-circle"
                                width="40" height="auto">
                            @endif
                        </div>
                        {{ $user->name }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-blue">
                <h3 class="text-white">Transaksi terakhir</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($data['newTransactions'] as $transaction)
                    <li class="list-group-item d-flex align-items-center">
                        <div class="float-left mr-3">
                            @if($transaction->user->profilpic == '')
                            <img src="{{ url('assets/image/userpic.svg') }}" class="rounded-circle" width="40"
                                height="auto">
                            @else
                            <img src="{{ url('assets/profilpic/' . $transaction->user->profilpic) }}"
                                class="rounded-circle" width="40" height="auto">
                            @endif
                        </div>
                        {{ $transaction->user->name }} - {{ $transaction->class->name }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-gradient-red">
                <h3 class="text-white">Kelas paling diminati</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($data['bestClasses'] as $bestClass)
                    <li class="list-group-item d-flex align-items-center">
                        <div class="float-left mr-3">
                            <img src="{{ url('cover/' . $bestClass->class->cover) }}" class="rounded" width="40"
                                height="auto">
                        </div>
                        {{ $bestClass->class->name }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>

</script>
@endpush
