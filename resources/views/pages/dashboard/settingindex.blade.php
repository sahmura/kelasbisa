@extends('layouts.master')
@section('title', "- Setting")
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">My Class</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('user') }}">Dashboards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Setting</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-profile">
            <img src="{{ url('assets/image/usersetting.jpg') }}" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center mb-2">
                <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                        <a href="#">
                            @if($data->profilpic == '')
                            <img src="{{ url('assets/image/userpic.svg') }}" class="rounded-circle" width="100"
                                height="auto">
                            @else
                            <img src="{{ url('assets/profilpic/' . $data->profilpic) }}" class="rounded-circle"
                                width="100" height="auto">
                            @endif
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-5">
                <div class="text-center">
                    <h5 class="h3">
                        {{ $data->name }}<span class="font-weight-light"></span>
                    </h5>
                    <div>
                        <i class="ni education_hat mr-2"></i>{{ $data->email }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mt-3">
            <div class="card-body">
                <form action="{{ url('setting/updatepic') }}" method="POST" id="profilpicform"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="profil">Profil Picture</label>
                        <input type="file" name="profil" id="profil" class="form-control" placeholder="Profil picture">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-md btn-primary w-100" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Sunting profil </h3>
                    </div>
                    <div class="col-4 text-right">
                        <button class="btn btn-md btn-primary" id="settingformbtn"><i class="ni ni-send"></i>
                            Update</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="POST" id="settingform">
                    <div class="form-group">
                        <label for="name">Nama lengkap</label>
                        <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control"
                            placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ $data->email }}" class="form-control"
                            placeholder="email@kamu.com" required>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow mt-3">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Sunting password </h3>
                    </div>
                    <div class="col-4 text-right">
                        <button class="btn btn-md btn-primary" id="passwordformbtn"><i class="ni ni-send"></i>
                            Update</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="POST" id="passwordform">
                    <div class="form-group">
                        <label for="oldpassword">Password lama</label>
                        <input type="password" name="oldpassword" id="oldpassword" class="form-control" required
                            placeholder="Password lama">
                    </div>
                    <div class="form-group">
                        <label for="newpassword">Password baru</label>
                        <input type="password" name="newpassword" id="newpassword" class="form-control" required
                            placeholder="Password baru">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Konfirmasi password baru</label>
                        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" required
                            placeholder="Konfirmasi password baru">
                        <span id="errorpass" class="text-danger"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
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
    });

    $('#settingformbtn').on('click', function () {
        var data = $('#settingform').serialize();
        $.ajax({
            url: "{{ url('setting/update') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: data,
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "error"
                    });
                }
                location.reload();
            }
        })
    });
    $('#passwordformbtn').on('click', function () {
        var data = $('#passwordform').serialize();
        $.ajax({
            url: "{{ url('setting/updatepassword') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: data,
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "error"
                    });
                }
                location.reload();
            }
        })
    });
    $('#profilpicbtn').on('click', function () {
        var data = $('#profilpicform').serialize();
        $.ajax({
            url: "{{ url('setting/updatepic') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: data,
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "error"
                    });
                }
                location.reload();
            }
        })
    });

    $('#confirmpassword').on('keyup', function () {
        if ($('#newpassword').val() != $('#confirmpassword').val()) {
            $('#errorpass').text('Password tidak sesuai');
        } else {
            $('#errorpass').text('');
        }
    })

</script>
@endpush
