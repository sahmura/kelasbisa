@extends('layouts.master')
@section('title', '- Admin area')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Admin</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card crad-stats shadow">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total kelas</h5>
                        <span class="h2 font-weight-bold mb-0"></span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="ni ni-book-bookmark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card crad-stats shadow">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total pengguna</h5>
                        <span class="h2 font-weight-bold mb-0"></span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="ni ni-book-bookmark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card crad-stats shadow">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total transaksi</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $totalClass }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-book-bookmark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="asignModal" tabindex="-1" role="dialog" aria-labelledby="asignModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="dataForm">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name">Nama user</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama user" required
                            readonly='readonly'>
                    </div>
                    <div class="form-group">
                        <label for="description">Pilih kelas</label>
                        <select name="class_id" id="class_id" class="custom-select">
                            <option value="0">Pilih Kelas</option>
                            @foreach($classes as $class)
                            <option value="{{$class->id}}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn" id="save-btn">Tambah data</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>

</script>
@endpush
