@extends('layouts.master')
@section('title', '- Detail Kelas')
@section('bg-header', 'bg-primary')
@push('css')
<style>
    @media (min-width: 768px) {
        .img-fluid {
            max-width: 60%;
            height: auto;
        }
    }
</style>
@endpush
@section('header-body')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-google-pages mr-2"></i>Detail Kelas</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('user') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('user/class') }}">Kelas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($data->name, 20) }}</li>
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
            <div class="card-body py-4">
                <div class="row">
                    <div class="col-lg-6">
                        <img class="mx-auto d-block img-fluid" src="{{ url('cover/' . $data->cover) }}?" alt="{{ $data->name }}" height="400">
                    </div>
                    <div class="col-lg-6 align-self-top">
                        <div class="single-pro-detail">
                            <p class="mb-1">{{ $data->category->name ?? 'Tidak berkategori' }}</p>
                            <div class="custom-border"></div>
                            <h3 class="pro-title">{{ $data->name }}</h3>
                            <p style='font-size: 1em'>{{ $data->speaker->name }}
                                <br><span class="text-muted">{{ $data->speaker->skill }}</span>
                            </p>
                            <div id="price-nocoupon">
                                <h2 class="pro-price">Rp{{ number_format($data->prices) }}</h2>
                            </div>
                            <div id="price-coupon" style="display: none;">
                                <h2 class="pro-price" id="discountPrices"></h2>
                            </div>
                            <h6 class="text-muted font-13">Fitur :</h6>
                            <ul class="list-unstyled pro-features border-0">
                                <li>Akses video selamanya</li>
                                <li>Dapat diakses di mana saja</li>
                                <li>Dapat diakses kapan saja</li>
                                @if($data->type != 'free')
                                <li>Sertifikat jika sudah menyelesaikan kelas</li>
                                <li>Group diskusi kelas</li>
                                @endif
                            </ul>
                            <div class="quantity mt-3 ">
                                @if($data->is_draft == 0)
                                @if($isOnList == 0)
                                @if($data->type == 'free')
                                <button class="btn btn-primary text-white px-5" id="addClassBtn">Ikuti kelas</button>
                                @else
                                <div class="form-group">
                                    <input type="text" name="coupon" id="coupon" placeholder="Masukan kode voucher" class='form-control' style="width: 200px;">
                                    <p id="errorCode"></p>
                                </div>
                                <button class="btn btn-primary text-white px-5" id="buyClassBtn">Beli kelas</button>
                                @endif
                                @else
                                <button class="btn btn-primary text-white px-5" id="playClassBtn">Play</button>
                                @endif
                                @else
                                <span class="btn btn-danger disabled">Diarsipkan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="single-pro-info-tab">
                    <ul class="nav nav-pills mb-0 nav-justified" id="list-keterangan" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-materi-tab" data-toggle="pill" href="#pills-materi" aria-selected="true">Materi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-description-tab" data-toggle="pill" href="#pills-description" aria-selected="false">Deskripsi</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="tab-content mt-4" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-materi">
                            <div class="row">
                                <div class="col-12">
                                    @foreach($listSubChapters as $subchapter)
                                    <h4 class="mt-3">{{ $subchapter->name }}</h4>
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
                        <div class="tab-pane fade" id="pills-description">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mt-3">Deskripsi</h4>
                                    <p class="lead">{!! $data->description !!}</p>
                                    <h4>Ketentuan</h4>
                                    <p class="lead">{!! $data->terms !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="buyClassModal" tabindex="-1" role="dialog" aria-labelledby="buyClassModalLabel" aria-hidden="true">
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
                        <b>0108901610018527 BTN a/n Khoerul Umam</b>
                    </li>
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
    $(document).ready(function() {
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

    $('#buyClassBtn').on('click', function() {

        var coupon = $('#coupon').val()
        if (coupon == '') {
            window.location.href = "{{ url('user/checkout/' . $data->id) }}"
        } else {
            window.location.href = "{{ url('user/checkout/' . $data->id ) }}" + '/' + coupon;
        }
    });

    $('#playClassBtn').on('click', function() {
        window.location.href = "{{ url('user/roll/' . $data->id) }}";
    });

    $('#addClassBtn').on('click', function() {

        window.location.href = "{{ url('user/checkout/' . $data->id) }}"
    });

    $('#coupon').on('keyup', function() {
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
            success: function(response) {
                if (response.status) {
                    $('#price-nocoupon').hide();
                    $('#price-coupon').show();
                    $('#discountPrices').html(response.newPrices + ' <span><del>Rp{{ number_format($data->prices) }}</del></span><small class="text-danger font-weight-bold ml-2">' + response.percent + '% Off</small>');
                    $('#errorCode').html(response.message);
                    $('#errorCode').removeClass('text-danger');
                    $('#errorCode').addClass('text-success');
                } else {
                    $('#price-nocoupon').show();
                    $('#price-coupon').hide();
                    $('#discountPrices').html("Rp{{ $data->prices }}")
                    $('#errorCode').html(response.message);
                    $('#errorCode').removeClass('text-success');
                    $('#errorCode').addClass('text-danger');

                }
            }
        })
    })
</script>
@endpush