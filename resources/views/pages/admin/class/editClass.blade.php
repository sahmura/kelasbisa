@extends('layouts.master')
@section('title', '- Edit Kelas')
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
                <li class="breadcrumb-item"><a
                        href="{{ url('admin/class/' . $class->id . '/detail') }}">{{ $class->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-6 col-5 text-right">
        <a class="btn btn-md btn-neutral" href="{{ url('admin/class') }}">Back</a>
    </div>
</div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card pb-5">
                <div class="card-header border-0">
                    <h3 class="mb-0">Edit kelas</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/class/edit') }}" method="POST" enctype="multipart/form-data"
                        id="newClassForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $class->id }}">
                        <div class="form-group">
                            <label for="name">Nama kelas</label>
                            <input type="text" name="name" id="name" class="form-control p-2" placeholder="Nama kelas"
                                required value="{{ $class->name }}">
                        </div>
                        <div class="form-group">
                            <label for="speakers">Pembawa materi</label>
                            <select name="speakers" id="speakers" class="custom-select" required>
                                <option value="0">Pilih pembicara</option>
                                @foreach($listSpeakers as $speaker)
                                <option value="{{ $speaker->id }}" @if($class->speaker_id == $speaker->id)
                                    selected='seleced' @endif>{{$speaker->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control"
                                placeholder="Deskripsi kelas" required>{{ $class->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori kelas</label>
                            <select name="category_id" id="category_id" class="custom-select" required>
                                <option value="0">Tak berkategori</option>
                                @foreach($listCategories as $category)
                                <option value="{{ $category->id }}" @if($category->id == $class->category_id)
                                    selected='selected' @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Tipe kelas</label>
                                    <select name="type" id="type" class="custom-select" required>
                                        <option value="premium" @if($class->type == 'premium') selected='selected'
                                            @endif>Premium</option>
                                        <option value="free" @if($class->type == 'free') selected='selected'
                                            @endif>Free</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prices">Harga</label>
                                    <input type="number" name="prices" id="prices" class="form-control" min="0" required
                                        placeholder="Harga kelas" value="{{ $class->prices }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="terms">Ketentuan kelas</label>
                            <textarea name="terms" id="terms" class="form-control" placeholder="Ketentuan kelas"
                                required>{{ $class->terms }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="modul_url">Modul</label>
                            <input type="text" name="modul_url" id="modul_url" class="form-control"
                                placeholder="Link modul" required value="{{ $class->modul_url }}">
                        </div>
                        <div class="form-group">
                            <label for="group_url">Group Link</label>
                            <input type="text" name="group_url" id="group_url" class="form-control"
                                placeholder="Link untuk Group" required value="{{ $class->group_discussion }}">
                        </div>
                        <div class="form-group">
                            <label for="is_draft">Aksi</label>
                            <select name="is_draft" id="is_draft" class="custom-select">
                                <option value="1" @if($class->is_draft == 1) selected='selected' @endif>Draft</option>
                                <option value="0" @if($class->is_draft == 0) selected='selected' @endif>Terbitkan
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover">Cover</label><br>
                            <img src="{{ url('cover/' . $class->cover) }}" alt="" class="my-3" height="200px"
                                width="auto"><br>
                            <input type="file" name="cover" id="cover" class="form-control" placeholder="Cover">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-lg btn-success float-right" type="submit" id="save-btn">Simpan
                                kelas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>

<script>
    $(document).ready(function () {
        $('#terms').summernote();
        $('#description').summernote();
    });
    $('#type').on('change', function () {
        if ($(this).val() == 'free') {
            $('#prices').val(0);
            $('#prices').attr('readonly', 'readonly');
        } else {
            $('#prices').removeAttr('readonly');
        }
    });

</script>
@endpush
@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
@endpush
