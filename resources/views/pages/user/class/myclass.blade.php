@extends('layouts.master')
@section('title', '- Daftar Kelas')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-google-pages mr-2"></i>Kelas Saya</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('user') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelas Saya</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    @if($listClasses->total() == 0)
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">Belum ada kelas</h3>
            </div>
        </div>
    </div>
    @else
    @foreach($listClasses as $class)
    <div class="col-md-3">
        <div class="card e-co-product p-0">
            <a href="{{ url('user/detail/' . $class->class->id . '/class') }}">
                <img class="img-fluid" src="{{ url('cover/' . $class->class->cover) }}" loading="lazy" alt="{{ $class->class->name }}">
            </a>
            <div class="card-body text-center product-info">
                <a href="{{ url('user/detail/' . $class->class->id . '/class') }}" class="product-title" style="margin-bottom: 10px;">{{ Str::limit($class->class->name, 20) }}</a>
                <p></p>
                <button class="btn btn-cart btn-sm waves-effect waves-light">{{ $class->class->category->name ?? 'Tidak berkategori' }}</button>
            </div>
            <div class="card-body socials-data pb-0">
                <div class="row text-center border-top m-0">
                    <div class="col-7 border-right py-3">
                        <p class="mt-0 mb-1">{{ $class->class->speaker->name }}</p>
                        <span class="font-14 text-muted">{{ $class->class->speaker->skill }}</span>
                    </div>
                    <div class="col-5 align-self-center">
                        @if($class->class->is_draft == 0)
                        <a href="{{ url('user/roll/' . $class->class->id) }}" style='font-size: 3em'><i class="mdi mdi-play-circle"></i></a>
                        @else
                        <a href="" class="btn btn-sm btn-danger  disabled">Diarsipkan</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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
        var cat_id = $(this).val();
        if (cat_id != 0) {
            window.location.href = "{{ url('user/myclass') }}" + '/' + cat_id;
        } else {
            window.location.href = "{{ url('user/myclass') }}";
        }
    });
</script>
@endpush