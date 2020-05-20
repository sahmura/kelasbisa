@extends('layouts.master')
@section('title', '- Daftar Kelas')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Daftar Kelas</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('user') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kelas</li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <select name="" id="category_id" class="custom-select">
            <option value="all" @if($category_id=='all' ) selected='selected' @endif>Semua kategori</option>
            @foreach($listCategories as $category)
            <option value="{{ $category->id }}" @if($category_id==$category->id) selected='selected'
                @endif>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <select name="" id="type" class="custom-select">
            <option value="all" @if($type=='all' ) selected='selected' @endif>Semua tipe</option>
            <option value="free" @if($type=='free' ) selected='selected' @endif>Kelas Gratis</option>
            <option value="premium" @if($type=='premium' ) selected='selected' @endif>Kelas Premium</option>
        </select>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <input type="text" name="classname" id="classname" class="form-control" placeholder="Cari kelas">
    </div>
</div>
@endsection
@section('content')
<div class="row mt-5">
    @if($listClasses->total() != 0)
    @foreach($listClasses as $class)
    <div class="col-md-4">
        <div class="card shadow">
            <img class="card-img-top" src="{{ url('cover/' . $class->cover) }}" loading="lazy" alt="{{ $class->name }}">
            <div class="card-body">
                <h3 class="card-title" style="margin-bottom: 10px;">{{ $class->name }} <span
                        class="badge badge-warning float-right">{{ ucfirst($class->type) }}</span></h3>
                {{ $class->category->name }}
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-4">
                        <span class="badge badge-secondary">{{ ucfirst($class->speakers) }}</span>
                    </div>
                    <div class="col-8">
                        <a href="{{ url('user/detail/' . $class->id . '/class') }}"
                            class="btn btn-sm btn-primary float-right"><i class="fas fa-search"></i> Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body text-center">
                <h3 class="card-title" style="margin-bottom: 10px;">Kelas tidak ditemukan</h3>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="row ">
    <div class="col-md-12 d-flex align-items-center justify-content-center">
        {{ $listClasses->links() }}
    </div>
</div>
@endsection
@push('js')
<script>
    $('#category_id').on('change', function () {
        var category = $('#category_id').val();
        var type = $('#type').val();
        if (category == 'all' && type == 'all') {
            window.location.href = "{{ url('user/class')}}";
        } else {
            window.location.href = "{{ url('user/class')}}" + '/' + category + '/' + type;
        }
    });
    $('#type').on('change', function () {
        var category = $('#category_id').val();
        var type = $('#type').val();
        if (category == 'all' && type == 'all') {
            window.location.href = "{{ url('user/class')}}";
        } else {
            window.location.href = "{{ url('user/class')}}" + '/' + category + '/' + type;
        }
    });
    $('#classname').on('change', function () {
        var name = $('#classname').val();
        window.location.href = "{{ url('user/class')}}" + '/search/' + name;
    });

</script>
@endpush
