@extends('layouts.home')
@push('css')
<link rel="stylesheet" href="{{ url('assets/argon/css/argon.css?v=1.2.0') }}" type="text/css">
@endpush
@section('page-header')
<div class="container shape-container d-flex align-items-center py-lg">
    <div class="col px-0">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <h1 class="text-white display-1">Detail kelas</h1>
                <p class="lead font-weight-thin text-white">Kelas terbaik dari kami</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <img class="card-img-top" src="{{ url('cover/' . $data->cover) }}" alt="Card image cap">
                            <div class="card-body">
                                <h5>{{ $data->name }}</h5>
                                <p>{{ $data->speakers }}</p>
                                <p>{!! $data->description !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="card shadow">
                            <div class="card-header">
                                <h6>Materi</h6>
                            </div>
                            <div class="card-body">
                                @foreach($listSubChapters as $subchapter)
                                <h3 class="">{{ $subchapter->name }}</h3>
                                <hr style="margin: 1em 0;">
                                <ul class="list-group">
                                    @foreach($listChapters as $chapter)
                                    @if($chapter->sub_chapter_id == $subchapter->id)
                                    <li class="list-group-item">{{$chapter->title}}
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 sticky-top">
                <div class="card card-profile shadow">
                    <div class="card-header">
                        <h5 class="display-6 text-center">Kelas {{ ucfirst($data->type) }}</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col">
                                <div class="row text-center">
                                    <div class="col-4  mt-3">
                                        <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                            <span class="heading">{{ $totalChapters }}</span>
                                        </div>
                                        <span class="description" style="font-weight: 300;">Video</span>
                                    </div>
                                    <div class="col-4  mt-3">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i
                                                class="ni @if($data->type != 'free') ni-check-bold @else ni-fat-remove @endif"></i>
                                        </div>
                                        <span class="description" style="font-weight: 300;">Konsultasi</span>
                                    </div>
                                    <div class="col-4  mt-3">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i
                                                class="ni @if($data->type != 'free') ni-check-bold @else ni-fat-remove @endif"></i>
                                        </div>
                                        <span class="description" style="font-weight: 300;">Sertifikat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span style="font-weight: 600;">Ketentuan</span>
                                <hr style="margin-top: 1em;">
                                <p>{!! $data->terms !!}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span style="font-weight: 600;">Harga</span>
                                <hr style="margin-top: 1em;">
                                <p>Rp{{ $data->prices }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-primary text-center">
                        @if($data->is_draft == 0)
                        @if($data->type == 'free')
                        <button class="btn btn-primary text-white" id="addClassBtn" style="box-shadow: none;">Ikuti
                            kelas</button>
                        @else
                        <button class="btn btn-primary text-white" id="buyClassBtn" style="box-shadow: none;">Beli
                            kelas</button>
                        @endif
                        @else
                        <span class="btn btn-danger disabled">Diarsipkan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $('#addClassBtn').on('click', function () {
        window.location.href = "{{ url('login') }}";
    });
    $('#buyClassBtn').on('click', function () {
        window.location.href = "{{ url('login') }}";
    });

</script>
@endpush
