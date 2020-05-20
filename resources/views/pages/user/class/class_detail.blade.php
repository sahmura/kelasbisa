@extends('layouts.master')
@section('title', '- Detail Kelas')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Detail Kelas</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('user') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('user/class') }}">Kelas</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->name }}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <img class="card-img-top" src="{{ url('cover/' . $data->cover) }}?" alt="Card image cap">
                    <div class="card-body">
                        <h2>{{ $data->name }}</h2>
                        <p>{{ $data->speaker->name }}</p>
                        <p>{!! $data->description !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Materi</h3>
                    </div>
                    <div class="card-body">
                        @foreach($listSubChapters as $subchapter)
                        <h3 class="mt-3">{{ $subchapter->name }}</h3>
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
        <div class="card card-profile">
            <div class="card-header">
                <h3 class="display-4 text-center">Kelas {{ ucfirst($data->type) }}</h3>
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
                        <p id="hargaAwal">Rp{{ $data->prices }}</p>
                        <p id="hargaDiskon"></p>
                    </div>
                </div>
                @if($isOnList == 0)
                @if($data->type == 'premium')
                <div class="row">
                    <div class="col">
                        <label for="coupon">Kupon</label>
                        <input type="text" name="coupon" id="coupon" class="form-control" placeholder="Kode kupon">
                        <p id="errorCode" class="text-danger"></p>
                    </div>
                </div>
                @endif
                @endif
            </div>
            <div class="card-footer bg-primary text-center">
                @if($data->is_draft == 0)
                @if($isOnList == 0)
                @if($data->type == 'free')
                <button class="btn btn-primary text-white" id="addClassBtn" style="box-shadow: none;">Ikuti
                    kelas</button>
                @else
                <button class="btn btn-primary text-white" id="buyClassBtn" style="box-shadow: none;">Beli
                    kelas</button>
                @endif
                @else
                <button class="btn btn-primary text-white" id="playClassBtn" style="box-shadow: none;">Play</button>
                @endif
                @else
                <span class="btn btn-danger disabled">Diarsipkan</span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="buyClassModal" tabindex="-1" role="dialog" aria-labelledby="buyClassModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title  text-white" id="buyClassModalLabel">Beli Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>Panduan pembelian kelas</h3>
                <hr>
                <ul class="list-group">
                    <li class="list-group-item">Selamat, kamu berhasil membeli kelas, namun masih belum bisa diakses
                    </li>
                    <li class="list-group-item">Silahkan transfer sebesar nominal akhir ke <br>
                        <b>0108901610018527 BTN a/n Khoerul Umam</b></li>
                    <li class="list-group-item">Setelah itu kirim bukti transfer ke No <b>085156257710</b> melalui
                        Whatsapp
                        disertai dengan data
                        berikut<br><br>
                        Nama : {{ Auth()->user()->name }}<br>
                        Email : {{ Auth()->user()->email }}
                    </li>
                    <li class="list-group-item">Setelah konfirmasi, kelas akan otomatis ada di menu kelas saya dalam
                        waktu 1x24 jam</li>
                    <li class="list-group-item">Pemberitahuan ini juga dikirimkan ke email {{ Auth()->user()->email }}
                    </li>
                    <li class="list-group-item">Terima Kasih :)</li>
                </ul>
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

        new Playerjs({
            id: "chapterPlayback",
            file: "https://www.youtube.com/watch?v=" + video
        });
    });

    $('#buyClassBtn').on('click', function () {

        var coupon = $('#coupon').val()
        if (coupon == '') {
            window.location.href = "{{ url('user/checkout/' . $data->id) }}"
        } else {
            window.location.href = "{{ url('user/checkout/' . $data->id ) }}" + '/' + coupon;
        }
    });

    $('#playClassBtn').on('click', function () {
        window.location.href = "{{ url('user/roll/' . $data->id) }}";
    });

    $('#addClassBtn').on('click', function () {

        window.location.href = "{{ url('user/checkout/' . $data->id) }}"
    });

    $('#coupon').on('keyup', function () {
        $.ajax({
            url: "{{ url('user/checkCoupon')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {
                code: $(this).val(),
                idclass: "{{ $data->id }}"
            },
            success: function (response) {
                if (response.status) {
                    $('#hargaAwal').css('text-decoration', 'line-through');
                    $('#hargaAwal').css('color', '#FA441B');
                    $('#hargaDiskon').css('font-weight', '600');
                    $('#hargaDiskon').show();
                    $('#hargaDiskon').html(response.newPrices);
                    $('#errorCode').html(response.message);
                    $('#errorCode').removeClass('text-danger');
                    $('#errorCode').addClass('text-success');
                } else {
                    $('#hargaAwal').css('text-decoration', 'none');
                    $('#hargaAwal').css('color', '#757F99');
                    $('#errorCode').html(response.message);
                    $('#errorCode').removeClass('text-success');
                    $('#errorCode').addClass('text-danger');
                    $('#hargaDiskon').hide();

                }
            }
        })
    })

</script>
@endpush
