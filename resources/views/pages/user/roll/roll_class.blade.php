@extends('layouts.rollclass')
@section('title', "- Rolling class")
@section('bg-header', 'bg-primary')
@section('sidebarroll')
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
                <!-- <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="..."> -->
                Kelasbisa
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <h6 class="navbar-heading p-0 text-muted">
                    <span class="docs-normal">Beranda</span>
                </h6>
                <hr class="my-2">
                <ul class="navbar-nav mb-5">
                    <li class="nav-item">
                        <a href="{{ url('user/myclass') }}" class="ml-4 btn btn-danger btn-sm">Kembali</a>
                    </li>
                </ul>
                @if($class->modul_url != '-')
                <h6 class="navbar-heading p-0 text-muted">
                    <span class="docs-normal">Modul</span>
                </h6>
                <hr class="my-2">
                <ul class="navbar-nav mb-5">
                    <li class="nav-item">
                        <a href="{{ $class->modul_url }}" class="ml-4 btn btn-info btn-sm">Download Modul</a>
                    </li>
                </ul>
                @endif
                <!-- Nav items -->
                @foreach($listSubChapters as $subchapter)
                <h6 class="navbar-heading p-0 text-muted">
                    <span class="docs-normal">{{ $subchapter->name }}</span>
                </h6>
                <hr class="my-2">
                <ul class="navbar-nav mb-3">
                    @foreach($listChapters as $chapter)
                    @if($chapter->sub_chapter_id == $subchapter->id)
                    <li class="nav-item ">
                        <a class="nav-link @if($chid == $chapter->id) active @endif"
                            href="{{ url('user/roll/' . $class->id . '/' . $chapter->id) }}">
                            <i class="ni ni-bold-right text-primary"></i>
                            <span class="nav-link-text">{{ $chapter->title }}</span>
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
                @endforeach
            </div>
        </div>
    </div>
</nav>

@endsection
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Kelas Saya</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('user') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('user/myclass') }}">Kelas Saya</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $class->name }}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            @if($initialState == 1)
            <div class="card-body">
                <h2>Kelas {{ $class->name }}</h2>
                <p>{!! $class->description !!}</p>
                <h4 class="mt-5">Ketentuan</h4>
                <hr class="my-2">
                <p>{!! $class->terms !!}</p>
                <h4 class="mt-5">Mulai kelas</h4>
                <hr class="my-2">
                <p>Silahkan pilih materi sesuai yang disediakan di sidebar di sebelah kanan</p>
            </div>
            @else
            <div class="card-body">
                <div id="chapterPlayback"></div>
                <script>
                    new Playerjs({
                        id: "chapterPlayback",
                        file: "https://www.youtube.com/watch?v={{ $rollChapter->video_url }}"
                    });

                </script>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('css')
<script src="{{ url('js/playerjs.js') }}"></script>
@endpush
