@extends('layouts.master')
@section('title', '- Proses Pembelian')
@section('bg-header', 'bg-primary')
@section('header-body')
<div class="row align-items-center py-4">
    <div class="col-lg-8 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Checkout Transaksi</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin/class') }}">Kelas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Transaksi Kelas</li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card pb-5 default">
                <div class="card-header">
                    <h3 class="mb-0">Detail Checkout Pembelian Kelas</h3>
                </div>
                <div class="card-body">
                    <p>Kamu sudah melakukan pembelian kelas dengan data berikut ini</p>
                    <ul class="list-group">
                        <input type="hidden" name="id" id="id" value="{{ $transaction_id }}">
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
                                    {{ $class->category->name}}
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
                    </ul>
                    <p class="mt-3">Namun, kelas belum dapat diakses karena belum melakukan pembayaran. Silahkan lakukan
                        pembayaran terlebih dahulu sesuai nominal harga akhir. Detail transaksi sudah dikirim ke email
                        {{ Auth()->user()->email }}</p>
                    <p>Jika ingin melakukan pembelian ulang kelas, silahkan batalkan transaksi ini.</p>
                    <div class="row mt-5">
                        <div class="col-12">
                            <button id="caraBayar" class="btn btn-md btn-success float-right mx-1">Cara
                                Pembayaran</button>
                            <button id="batalkanTransaksi" class="btn btn-md btn-danger float-right mx-1">Batalkan
                                Transaksi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="buyClassModal" tabindex="-1" role="dialog" aria-labelledby="buyClassModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
@push('js')
<script>
    $('#caraBayar').on('click', function () {
        $('#buyClassModal').modal('show');
    });

    $('#batalkanTransaksi').on('click', function () {
        $('#loaderSpin').fadeIn('slow');
        $.ajax({
            url: "{{ url('user/batalkanTransaksi') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            data: {
                id: $('#id').val()
            },
            success: function (response) {
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
        })
    });

</script>
@endpush
