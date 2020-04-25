@extends('layouts.master')
@section('title', '- Daftar Kelas')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">My Class</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('user') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Class</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-6 col-5 text-right">
        <select name="" id="category_id" class="custom-select">
            <option value="0">Semua kategori</option>
            @foreach($listCategories as $category)
            <option value="{{ $category->id }}" @if($category_id==$category->id) selected='selected'
                @endif>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    @if($listClasses->total() == 0)
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="text-center">Belum ada kelas</h3>
            </div>
        </div>
    </div>
    @else
    @foreach($listClasses as $class)
    <div class="col-md-4">
        <div class="card shadow">
            <img class="card-img-top" src="{{ url('cover/' . $class->cover) }}" alt="{{ $class->name }}">
            <div class="card-body">
                <h3 class="card-title" style="margin-bottom: 10px;">{{ $class->name }}</h3>
                {{ $class->category->name }}
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-4">
                        <h3 class="btn btn-md btn-warning">{{ ucfirst($class->type) }}</h3>
                    </div>
                    <div class="col-8">
                        <a href="{{ url('user/roll/' . $class->id) }}" class="btn btn-md btn-primary float-right"><i
                                class="ni ni-button-play"></i> Play</a>
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
    $('#category_id').on('change', function () {
        var cat_id = $(this).val();
        if (cat_id != 0) {
            window.location.href = "{{ url('user/myclass') }}" + '/' + cat_id;
        } else {
            window.location.href = "{{ url('user/myclass') }}";
        }
    });

</script>
@endpush
