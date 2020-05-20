@extends('layouts.master')
@section('title', '- Pengelolaan Kelas')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Class</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboards</a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin/class') }}">Class</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-6 col-5 text-right">
        <a href="{{ url('admin/class/' . $data->id .'/edit') }}" class="btn btn-md btn-neutral"
            id="editClassBtn">Edit</a>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <x-classdetail class="col-md-8" :cover="$data->cover" :name="$data->name" :speakers="$data->speaker->name"
        :description="$data->description" />
    <div class="col-md-4 sticky-top">
        <div class="card card-profile">
            <div class="card-header text-center">
                <h3 class="display-4 text-center">Kelas {{ ucfirst($data->type) }}</h3>
                @if($data->is_draft == 1)
                <span class="btn btn-danger disabled">Diarsipkan</span>
                @endif
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col">
                        <div class="card-profile-stats d-flex justify-content-center">
                            <div>
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <span class="heading">{{ $totalChapters }}</span>
                                </div>
                                <span class="description" style="font-weight: 600;">Video</span>
                            </div>
                            <div>
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i
                                        class="ni @if($data->type != 'free') ni-check-bold @else ni-fat-remove @endif"></i>
                                </div>
                                <span class="description" style="font-weight: 600;">Konsultasi</span>
                            </div>
                            <div>
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i
                                        class="ni @if($data->type != 'free') ni-check-bold @else ni-fat-remove @endif"></i>
                                </div>
                                <span class="description" style="font-weight: 600;">Sertifikat</span>
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
                <a href="">
                    <h3 class="display-5 text-white"></h3>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Materi</h3>
            </div>
            <div class="card-body">
                @foreach($listSubChapters as $subchapter)
                <h3 class="mt-5">{{ $subchapter->name }} <button data-id="{{ $subchapter->id }}"
                        data-name="{{ $subchapter->name }}"
                        class="btn btn-sm btn-danger float-right mx-1 btn-delete-subchapter"><i
                            class="fas fa-trash-alt"></i></button>
                    <button class="btn btn-sm btn-warning float-right btn-edit-subchapter"
                        data-id="{{ $subchapter->id }}" data-name="{{ $subchapter->name }}"><i
                            class="fas fa-pencil-alt"></i></button></h3>
                <hr style="margin: 1em 0;">
                <ul class="list-group">
                    @foreach($listChapters as $chapter)
                    @if($chapter->sub_chapter_id == $subchapter->id)
                    <li class="list-group-item">{{$chapter->title}}
                        <button data-id="{{ $chapter->id }}" data-title="{{ $chapter->title }}"
                            class="btn btn-sm btn-danger float-right btn-delete-chapter"><i
                                class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-sm btn-warning float-right btn-edit-chapter mx-1"
                            data-id="{{ $chapter->id }}" data-title="{{ $chapter->title }}"
                            data-video="{{ $chapter->video_url }}" data-desc="{{ $chapter->description }}"
                            data-subchapter="{{ $chapter->sub_chapter_id }}"> <i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-sm btn-primary float-right btn-detail-chapter"
                            data-title="{{ $chapter->title }}" data-video="{{ $chapter->video_url }}"
                            data-desc="{{ $chapter->description }}"> <i class="fas fa-search"></i></button>
                    </li>
                    @endif
                    @endforeach
                </ul>

                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3>Kelola materi</h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="materiTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="chaptertab-tab" data-toggle="tab" href="#chaptertab" role="tab"
                            aria-controls="chaptertab" aria-selected="true">Chapter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="subchaptertab-tab" data-toggle="tab" href="#subchaptertab" role="tab"
                            aria-controls="subchaptertab" aria-selected="false">Sub Chapter</a>
                    </li>
                </ul>

                <div class="tab-content mt-5" id="myTabContent">
                    <div class="tab-pane fade show active" id="chaptertab" role="tabpanel"
                        aria-labelledby="chaptertab-tab">
                        <form action="" method="POST" id="chapterform">
                            @csrf
                            <input type="hidden" name="class_id" id="" value="{{ $data->id }}">
                            <input type="hidden" name="id" id="chapter_id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label for="title">Nama chapter</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Judul chapter" required>
                            </div>
                            <div class="form-group">
                                <label for="video_url">Url Video</label>
                                <input type="text" name="video_url" id="video_url" class="form-control"
                                    placeholder="Url Video" required>
                            </div>
                            <div class="form-group">
                                <label for="subchapter">Sub chapter</label>
                                <select name="sub_chapter_id" id="subchapter" class="custom-select">
                                    <option value="0">Pilih Sub Chapter</option>
                                    @foreach($listSubChapters as $subchapter)
                                    <option value="{{ $subchapter->id }}">{{ $subchapter->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" id="description"
                                    placeholder="Deskripsi chapter" required></textarea>
                            </div>
                            <div class="form-group">
                                <button id="add-chapter" class="btn btn-success btn-md" type="button"><i
                                        class="fas fa-plus"></i>
                                    Tambah</button>
                                <button id="edit-chapter" class="btn btn-warning btn-md" type="button"><i
                                        class="fas fa-pencil-alt"></i>
                                    Sunting</button>
                                <button id="batal-edit-chapter" class="btn btn-danger btn-md"
                                    type="button">Batal</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="subchaptertab" role="tabpanel" aria-labelledby="subchaptertab-tab">
                        <form action="" method="POST" id="subchapterform">
                            @csrf
                            <input type="hidden" value="{{ $data->id }}" name="class_id">
                            <input type="hidden" value="" name="id" id="subchapter_id">
                            <div class="form-group">
                                <label for="subname">Sub chapter</label>
                                <input type="text" name="name" id="subname" class="form-control"
                                    placeholder="Sub chapter" required>
                            </div>
                            <div class="form-group">
                                <label for="subdescription">Deskripsi</label>
                                <textarea name="description" id="subdescription" class="form-control" required
                                    placeholder="Deskripsi sub chapter"></textarea>
                            </div>
                            <button class="btn btn-md btn-success" id="add-sub-chapter" type="button">Tambah</button>
                            <button class="btn btn-md btn-warning" id="edit-sub-chapter" type="button">Sunting</button>
                            <button class="btn btn-md btn-danger" id="batal-sub-chapter" type="button">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailchaptermodal" tabindex="-1" role="dialog" aria-labelledby="detailchaptermodalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailchaptermodalLabel">Detail chapter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h3 id="titleDetail" class="mb-3">Judul chapter</h3>
                <div id="chapterPlayback"></div>
                <p id="descDetail" class="mt-3">Deskripsi</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('css')
<script src="{{ url('js/playerjs.js') }}"></script>
@endpush
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


        $('#edit-chapter').hide();
        $('#batal-edit-chapter').hide();
        $('#edit-sub-chapter').hide();
        $('#batal-sub-chapter').hide();
        $('#add-chapter').show();
        $('#chapterform')[0].reset();
        $('#subchapterform')[0].reset();
    });

    $('#batal-edit-chapter').on('click', function () {
        $('#edit-chapter').hide();
        $('#batal-edit-chapter').hide();
        $('#add-chapter').show();
        $('#chapterform')[0].reset();
    });

    $('#batal-sub-chapter').on('click', function () {
        $('#edit-sub-chapter').hide();
        $('#batal-sub-chapter').hide();
        $('#add-sub-chapter').show();
        $('#subchapterform')[0].reset();
    });

    $('.btn-detail-chapter').on('click', function () {
        var title = $(this).data('title');
        var video = $(this).data('video');
        var desc = $(this).data('desc');

        $('#titleDetail').html(title);
        $('#descDetail').html(desc);
        new Playerjs({
            id: "chapterPlayback",
            file: "https://www.youtube.com/watch?v=" + video
        });

        $('#detailchaptermodal').modal('show');
    });

    $('#add-chapter').on('click', function () {
        $('#loaderSpin').fadeIn('slow');
        var data = $('#chapterform').serialize();
        $.ajax({
            url: "{{ url('admin/class/chapter/new') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            data: data,
            success: function (response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        location.reload();
                    });
                }
            }
        });
    });

    $('#add-sub-chapter').on('click', function () {
        $('#loaderSpin').fadeIn('slow');
        var data = $('#subchapterform').serialize();
        $.ajax({
            url: "{{ url('admin/class/subchapter/new') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: data,
            success: function (response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        location.reload();
                    });
                }
            }
        });
    });

    $('#edit-sub-chapter').on('click', function () {
        $('#loaderSpin').fadeIn('slow');
        var data = $('#subchapterform').serialize();
        $.ajax({
            url: "{{ url('admin/class/subchapter/edit') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            data: data,
            success: function (response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        location.reload();
                    });
                }
            }
        });
    });

    $('#edit-chapter').on('click', function () {
        $('#loaderSpin').fadeIn('slow');
        var data = $('#chapterform').serialize();
        $.ajax({
            url: "{{ url('admin/class/chapter/edit') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            data: data,
            success: function (response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'success'
                    }).then((Confirm) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: 'error'
                    }).then((Confirm) => {
                        location.reload();
                    });
                }
            }
        });
    });

    $('.btn-edit-chapter').on('click', function () {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var video = $(this).data('video');
        var desc = $(this).data('desc');
        var subchapter = $(this).data('subchapter');

        $('#edit-chapter').show();
        $('#add-chapter').hide();
        $('#batal-edit-chapter').show();
        $('#subchaptertab-tab').removeClass('active');
        $('#chaptertab-tab').addClass('active');
        $('#chaptertab').addClass('active');
        $('#chaptertab').addClass('show');
        $('#subchaptertab').removeClass('active');
        $('#subchaptertab').removeClass('show');

        $('#chapter_id').val(id);
        $('#title').val(title);
        $('#video_url').val(video);
        $('#subchapter').val(subchapter);
        $('#description').val(desc);
    });

    $('.btn-edit-subchapter').on('click', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var desc = $(this).data('desc');

        $('#edit-sub-chapter').show();
        $('#add-sub-chapter').hide();
        $('#batal-sub-chapter').show();
        $('#chaptertab-tab').removeClass('active');
        $('#subchaptertab-tab').addClass('active');
        $('#subchaptertab').addClass('active');
        $('#subchaptertab').addClass('show');
        $('#chaptertab').removeClass('active');
        $('#chaptertab').removeClass('show');

        $('#subchapter_id').val(id);
        $('#subname').val(name);
        $('#subdescription').val(desc);
    });

    $('.btn-delete-chapter').on('click', function () {
        Swal.fire({
            title: 'Apakah kamu yakin hapus chapter?',
            text: 'Chapter "' + $(this).data('title') + '" akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F5365C',
            confirmButtonText: 'Ya, hapus!'
        }).then((Confirm) => {
            if (Confirm.value) {
                $('#loaderSpin').fadeIn('slow');
                $.ajax({
                    url: "{{ url('admin/class/chapter/delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'delete',
                    data: {
                        id: $(this).data('id'),
                    },
                    success: function (response) {
                        $('#loaderSpin').fadeOut('slow');
                        if (response.status) {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'success'
                            }).then((Confirm) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'error'
                            }).then((Confirm) => {
                                location.reload();
                            });
                        }
                    }

                })
            }
        });
    });

    $('.btn-delete-subchapter').on('click', function () {
        Swal.fire({
            title: 'Apakah kamu yakin hapus sub chapter?',
            text: 'Semua chapter dalam sub ini akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F5365C',
            confirmButtonText: 'Ya, hapus!'
        }).then((Confirm) => {
            if (Confirm.value) {
                $('#loaderSpin').fadeIn('slow');
                $.ajax({
                    url: "{{ url('admin/class/subchapter/delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'delete',
                    data: {
                        id: $(this).data('id'),
                    },
                    success: function (response) {
                        $('#loaderSpin').fadeOut('slow');
                        if (response.status) {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'success'
                            }).then((Confirm) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: response.message,
                                text: response.notes,
                                icon: 'error'
                            }).then((Confirm) => {
                                location.reload();
                            });
                        }
                    }

                })
            }
        });
    });

</script>
@endpush
