@extends('layouts.master')
@section('title', '- Daftar Kelas')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-google-pages mr-2"></i>Telusuri Kelas</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Kelas</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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
            </div>
        </div>
    </div>
</div>


<div class="row">
    @if($listClasses->total() != 0)
    @foreach($listClasses as $class)
    <div class="col-md-3">
        <div class="card e-co-product p-0">
            <a href="{{ url('user/detail/' . $class->id . '/class') }}">
                <img class="img-fluid" src="{{ url('cover/' . $class->cover) }}" alt="{{ $class->name }}">
            </a>
            <div class="card-body text-center product-info">
                <a href="{{ url('user/detail/' . $class->id . '/class') }}" class="product-title" style="margin-bottom: 10px;">{{ Str::limit($class->name,20) }}</a>
                <p class="product-price">Rp{{ number_format($class->prices)  }}</p>
                <button class="btn btn-cart btn-sm waves-effect waves-light">{{ $class->category->name ?? 'Tidak berkategori' }}</button>
            </div>
            <div class="card-body socials-data pb-0">
                <div class="row text-center border-top m-0">
                    <div class="col-7 border-right py-3">
                        <p class="mt-0 mb-1">{{ $class->speaker->name }}</p>
                        <span class="font-14 text-muted">{{ $class->speaker->skill }}</span>
                    </div>
                    <div class="col-5 py-3">
                        <p class="mt-0 mb-1">Kelas</p>
                        <span class="font-14 text-muted">{{ ucfirst($class->type) }}</span>
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
    $('#category_id').on('change', function() {
        var category = $('#category_id').val();
        var type = $('#type').val();
        if (category == 'all' && type == 'all') {
            window.location.href = "{{ url('user/class')}}";
        } else {
            window.location.href = "{{ url('user/class')}}" + '/' + category + '/' + type;
        }
    });
    $('#type').on('change', function() {
        var category = $('#category_id').val();
        var type = $('#type').val();
        if (category == 'all' && type == 'all') {
            window.location.href = "{{ url('user/class')}}";
        } else {
            window.location.href = "{{ url('user/class')}}" + '/' + category + '/' + type;
        }
    });
    $('#classname').on('change', function() {
        var name = $('#classname').val();
        window.location.href = "{{ url('user/class')}}" + '/search/' + name;
    });
</script>
@endpush