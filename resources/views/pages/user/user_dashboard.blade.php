@extends('layouts.master')
@section('title', '- Dashboard')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            @if($isMentor != 0)
            <div class="float-right align-item-center mt-2">
                <a href="{{ url('user/statistic') }}" class="btn btn-info px-4 align-self-center report-btn">Create Report</a>
            </div>
            @endif
            <h4 class="page-title mb-2"><i class="mdi mdi-google-pages mr-2"></i>Beranda</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Beranda</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@section('content')
<div class="row mt-3">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8 align-self-center">
                        <h4 class="mt-0 header-title">Kelas diikuti</h4>
                        <h2 class="mt-0 font-weight-bold text-dark">{{ $totalClass }}</h2>
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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8 align-self-center">
                        <h4 class="header-title mt-0">Terakhir diakses</h4>
                        @if(!empty($lastClass) && $lastClass->chapter_id != 0)
                        <h4 class="mt-0 font-weight-bold text-dark">{{ $lastClass->class->name }} -
                            {{ $lastClass->chapter->title }}
                        </h4>
                    </div>
                    <div class="col-4 align-self-center text-center">
                        <a href="{{ url('user/roll/' . $lastClass->class_id . '/' . $lastClass->chapter_id) }}" style='font-size: 3em'>
                            <i class="mdi mdi-play-circle"></i>
                        </a>
                        @else
                        <h4 class="mt-0 font-weight-bold text-dark">Belum mengambil kelas</h4>
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