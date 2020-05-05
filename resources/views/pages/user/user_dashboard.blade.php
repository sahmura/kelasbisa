@extends('layouts.master')
@section('title', '- Dashboard')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Beranda</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Beranda</li>
            </ol>
        </nav>
    </div>
</div>
@section('content')
<div class="row mt-3">
    <div class="col-md-3">
        <div class="card crad-stats shadow">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Kelas diikuti</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $totalClass }}</span>
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
    <div class="col-md-9">
        <div class="card crad-stats shadow">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Terakhir diakses</h5>
                        @if(!empty($lastClass) && $lastClass->chapter_id != 0)
                        <span class="h2 font-weight-bold mb-0">{{ $lastClass->class->name }} -
                            {{ $lastClass->chapter->title }}</span>
                    </div>
                    <div class="col-auto">
                        <a href="{{ url('user/roll/' . $lastClass->class_id . '/' . $lastClass->chapter_id) }}">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-button-play"></i>
                            </div>
                        </a>
                        @else
                        <span class="h2 font-weight-bold mb-0">Belum mengambil kelas</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endsection
@push('js')
<script>
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

</script>
@endpush
