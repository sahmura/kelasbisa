@extends('layouts.home')
@section('page-header')
<div class="container shape-container d-flex align-items-center py-lg">
    <div class="col px-0">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <img src="{{ url('logo/logowhite.svg') }}" alt="Logo kelasbisa" height="100" width="auto" class="mb-3">
                <h1 class="text-white display-1">Cara Pembayaran</h1>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="section features-1">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <h3 class="display-3">Cara Pembayaran di Kelasbisa</h3>
                <p class="lead">Pembayaran di Kelasbisa hanya dapat dilakukan jika pengguna sudah terdaftar</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <p class="lead"><b>Mendaftar di platform Kelasbisa</b></p>
                <p class="lead">Daftar kelas ada di halaman daftar kelas, bagi teman-teman yang ingin melihat-lihat,
                    bisa melalui menu tersebut. Namun, jika pengguna ingin membeli kelas, pengguna harus login terlebih
                    dahulu. Jika belum mempunyai akun Kelasbisa, maka pengguna wajib mendaftarkan diri di Kelasbisa.</p>
                <p class="lead"><b>Pilih kelas</b></p>
                <p class="lead">Ada dua tipe kelas, yaitu kelas gratis dan kelas premium. Kelas gratis bisa diakses oleh
                    pengguna terdaftar dan dapat dilihat kapan saja. Sedangkan kelas premium hanya akan diberikan kepada
                    pengguna yang sudah mengkonfirmasi pembayaran. Pilih kelas premium, lalu beli kelas, dan silakan cek
                    email untuk instruksi berikutnya</p>
                <p class="lead"><b>Proses transaksi</b></p>
                <p class="lead">Jika sudah mengklik beli kelas dan mendapatkan email detail pembayaran, silahkan
                    melakukan transfer ke nomor rekening yang sudah dikirimkan kemudian upload bukti transfer ke nomor
                    yang diberikan juga di email yang sudah didaftarkan.</p>
                <p class="lead"><b>Hubungi kami</b></p>
                <p class="lead">Jika sudah membeli kelas dan transfer tapi belum mendapatkan email, kirim bukti transfer
                    dan silahkan hubungi kami sehingga kami bisa mendaftarkan kelas ke email yang sudah didaftarkan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
