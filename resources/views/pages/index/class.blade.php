@extends('layouts.home')
@section('page-header')
<div class="container shape-container d-flex align-items-center py-lg">
    <div class="col px-0">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <h1 class="text-white display-1">Daftar Kelas</h1>
                <p class="lead font-weight-thin text-white">Kelas terbaik dari kami</p>
                <div class="btn-wrapper mt-4">
                    <div class="row">
                        <div class="col">
                            <select name="category_id" id="category_id" class="custom-select">
                                <option value="all" @if($category=="all" ) selected='selected' @endif>Semua kategori
                                </option>
                                @foreach($categories as $categorydata)
                                <option value="{{ $categorydata->id }}" @if($category==$categorydata->id)
                                    selected='selected' @endif>{{ $categorydata->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="type" id="type" class="custom-select">
                                <option value="all" @if($type=="all" ) selected='selected' @endif>Semua tipe</option>
                                <option value="free" @if($type=="free" ) selected='selected' @endif>Kelas gratis
                                </option>
                                <option value="premium" @if($type=="premium" ) selected='selected' @endif>Kelas premium
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <input type="text" name="classname" id="classname" class="form-control"
                                placeholder="Ketikan nama kelas">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="section" id="listclass">
    <div class="container">
        @if($classes->total() != 0)
        <div class="row">
            @foreach($classes as $class)
            <div class="col-md-4 mt-3">
                <div class="card shadow">
                    <img class="card-img-top" src="{{ url('cover/' . $class->cover) }}" loading="lazy"
                        alt="{{ $class->name }}">
                    <div class="card-body">
                        <h6 class="card-title" style="margin-bottom: 10px;">{{ $class->name }} <span
                                class="badge badge-warning float-right">{{ ucfirst($class->type) }}</span></h6>
                        {{ $class->category->name }}
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-4">
                                <span class="badge badge-default">{{ ucfirst($class->speaker->name) }}</span>
                            </div>
                            <div class="col-8">
                                <a href="{{ url('detail/' . $class->id) }}"
                                    class="btn btn-sm btn-primary float-right"><i class="fas fa-search"></i>
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col-md-12 d-flex align-items-center justify-content-center">
                {{ $classes->links() }}
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h6 class="card-title" style="margin-bottom: 10px;">Kelas tidak ditemukan</h6>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@push('js')
<script>
    $('#category_id').on('change', function () {
        var category = $('#category_id').val();
        var type = $('#type').val();
        if (category == 'all' && type == 'all') {
            window.location.href = "{{ url('class')}}";
        } else {
            window.location.href = "{{ url('class')}}" + '/' + category + '/' + type;
        }
    });
    $('#type').on('change', function () {
        var category = $('#category_id').val();
        var type = $('#type').val();
        if (category == 'all' && type == 'all') {
            window.location.href = "{{ url('class')}}";
        } else {
            window.location.href = "{{ url('class')}}" + '/' + category + '/' + type;
        }
    });

    $('#classname').on('change', function () {
        var name = $('#classname').val();
        window.location.href = "{{ url('class')}}" + '/search/' + name;
    });

</script>
@endpush
