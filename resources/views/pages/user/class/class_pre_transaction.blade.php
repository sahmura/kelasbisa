@extends('layouts.master')
@section('title', '- Proses Pembelian')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-google-pages mr-2"></i>Checkout</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/class') }}">Kelas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transaksi Kelas</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card pb-5 default">
                <div class="card-body">
                    <h5 class="card-title">Checkout Pembelian Kelas</h5>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-4">
                                    Nama Kelas
                                </div>
                                <div class="col-8">
                                    {{ $class->name }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-4">
                                    Kategori
                                </div>
                                <div class="col-8">
                                    {{ $class->category->name ?? 'Tidak berkategori'}}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-4">
                                    Tipe Kelas
                                </div>
                                <div class="col-8">
                                    {{ ucfirst($class->type) }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-4">
                                    Harga
                                </div>
                                <div class="col-8">
                                    @if($coupon == null)
                                    Rp{{number_format($class->prices)}}
                                    @else
                                    <span style="text-decoration: line-through;">Rp{{number_format($class->prices)}}</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-4">
                                    Kode Kupon
                                </div>
                                <div class="col-8">
                                    {{ $coupon ?? '-'}}
                                    <input type="hidden" name="coupon" id="coupon" value="{{ $coupon ?? ''}}">
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-4">
                                    Harga Akhir
                                </div>
                                <div class="col-8">
                                    <b>Rp{{ number_format($class->prices - $discount)}}</b>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="row mt-5">
                        <div class="col-12">
                            <button @if($class->prices - $discount == 0) id="joinClass" @else id="buyClass" @endif
                                class="btn
                                btn-md btn-success float-right">Proses</button>
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
            <div class="modal-header">
                <h5 class="modal-title" id="buyClassModalLabel">Panduan pembelian kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
@push('js')
<script>
    $('#buyClass').on('click', function() {
        $('#loaderSpin').fadeIn('slow');
        $.ajax({
            url: "{{ url('user/buyclass') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {
                class_id: "{{ $class->id }}",
                user_id: "{{ Auth()->user()->id }}",
                code: $('#coupon').val()
            },
            success: function(response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "success"
                    }).then((Confirm) => {
                        if (Confirm.value) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "error"
                    });
                }
            }
        });
    });

    $('#joinClass').on('click', function() {
        $('#loaderSpin').fadeIn('slow');
        $.ajax({
            url: "{{ url('user/joinclass') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {
                class_id: "{{ $class->id }}",
                _token: "{{ csrf_token() }}",
                user_id: "{{ Auth()->user()->id }}",
                status: 'done'
            },
            success: function(response) {
                $('#loaderSpin').fadeOut('slow');
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "success"
                    }).then((Confirm) => {
                        if (Confirm.value) {
                            window.location.href = '{{ url("user/myclass") }}';
                        }
                    });
                } else {
                    Swal.fire({
                        title: response.message,
                        text: response.notes,
                        icon: "error"
                    });
                }
            }
        })
    });
</script>
@endpush