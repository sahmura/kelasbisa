@extends('layouts.rollclassnew')
@section('title', "- Rolling class")
@section('bg-header', 'bg-primary')
@section('sidenav')

<div class="left-sidenav">
    <ul class="metismenu left-sidenav-menu" id="side-nav">
        <li class="nav-link">
            <a href="{{ url('user/myclass') }}" class="btn btn-danger btn-sm text-white">Kembali</a>
        </li>
        @if($class->modul_url != '-')
        <li class="menu-title">Modul</li>
        <li class="nav-link">
            <a href="{{ $class->modul_url }}" class="btn btn-info btn-sm">Download Modul</a>
        </li>
        @endif
        @if($class->group_discussion != '-')
        <li class="menu-title">Grup Diskusi</li>
        <li class="nav-link">
            <a href="{{ $class->group_discussion }}" class="btn btn-success btn-sm">Gabung Grup</a>
        </li>
        @endif
        @foreach($listSubChapters as $subchapter)
        <li class="menu-title">
            <h6>{{ $subchapter->name }}</h6>
        </li>
        @foreach($listChapters as $chapter)
        @if($chapter->sub_chapter_id == $subchapter->id)
        <li class="nav-link ">
            <a class="@if($chid == $chapter->id) active @endif" href="{{ url('user/roll/' . $class->id . '/' . $chapter->id) }}">
                @if(in_array($chapter->id, $getListChapterDone))
                <i class="mdi mdi-check-circle text-success"></i>
                @endif
                <span>{{ Str::limit($chapter->title, 15) }}</span>
            </a>
        </li>
        @endif
        @endforeach
        @endforeach
    </ul>
</div>
@endsection
@section('header-body')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-google-pages mr-2"></i>{{ $class->name }}</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('user') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('user/myclass') }}">Kelas Saya</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($class->name, 20) }}</li>
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
            @if($initialState == 1)
            <div class="card-body">
                <h5 class="card-title">Kelas {{ $class->name }}</h5>
                <p>{!! $class->description !!}</p>
                <h5 class="mt-5">Ketentuan</h5>
                <hr class="my-2">
                <p>{!! $class->terms !!}</p>
                <h5 class="mt-5">Mulai kelas</h5>
                <hr class="my-2">
                <p>Silahkan pilih materi sesuai yang disediakan di sidebar di sebelah kiri</p>
            </div>
            @else
            <div class="card-body">
                <div class="text-right">
                    @if(in_array($chid, $getListChapterDone))
                    <button class="btn btn-warning mb-5 px-5" id="uncheck-button">Tandai Belum Selesai</button>
                    @else
                    <button class="btn btn-primary mb-5 px-5" id="check-button">Tandai Selesai</button>
                    @endif
                </div>
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
@push('js')
<script>
    $('#check-button').on('click', function() {
        $.ajax({
            url: "{{ url('user/class/chapter/checkChapter') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {
                class_id: "{{ $class->id }}",
                chapter_id: "{{ $chid }}",
            },
            success: function(response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        $('#categoryModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        $('#categoryModal').modal('hide');
                        location.reload();
                    });
                }
            }
        });
    });

    $('#uncheck-button').on('click', function() {
        $.ajax({
            url: "{{ url('user/class/chapter/uncheckChapter') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {
                class_id: "{{ $class->id }}",
                chapter_id: "{{ $chid }}",
            },
            success: function(response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        $('#categoryModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        $('#categoryModal').modal('hide');
                        location.reload();
                    });
                }
            }
        });
    });
</script>
@endpush