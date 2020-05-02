@extends('layouts.home')
@section('page-header')
<div class="container shape-container d-flex align-items-center py-lg">
    <div class="col px-0">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <img src="{{ url('logo/logowhite.svg?') }}" alt="Logo kelasbisa" height="100" width="auto" class="mb-3">
                <h1 class="text-white display-1">Kebijakan Privasi</h1>
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
                <h3 class="display-3">Kebijakan Privasi Kelasbisa</h3>
                <p class="lead">Kelasbisa merupakan platform belajar online dengan berbagai kelas dari berbagai bidang
                    ilmu. </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <p class="lead">Ketika pengguna mendaftar di Kelasbisa, pengguna akan mengisi nama dan email serta
                    password yang akan digunakan di dalam platform Kelasbisa. Semua data akan di simpan di database
                    kami sebagaimana digunakan hanya untuk kepentingan autentikasi saat melakukan proses login ke dalam
                    Kelasbisa. Nama boleh diisi dengan nama yang bukan nama asli, namun ketika nama tersebut bukan nama
                    asli, maka semua data termasuk sertifikat kelas akan diberikan kepada nama tersebut </p>
                <p class="lead"><b>Penggunaan Email</b></p>
                <p class="lead">Email digunakan untuk autentikasi ketika pengguna akan masuk ke dalam aplikasi Kelas
                    Bisa. Pengguna tidak akan bisa mengakses kelas selama email belum dikonfirmasi. Konfirmasi email
                    bertujuan untuk mengidentifikasi pengguna dan meminimalisasi pengguna palsu dan atau spam yang akan
                    memperlambat kinerja platform sehingga mengganggu kenyamanan pengguna lain. Konfirmasi email juga
                    bertujuan jika suatu saat pengguna tidak bisa masuk ke dalam kelas karena lupa password atau hal
                    lain, sehingga kami dapat menghubungi melalui email yang didaftarkan. Email juga menjadi syarat
                    utama bagi yang ingin membeli kelas, karena ketika membeli kelas, maka kami akan memasukkan kelas ke
                    dalam akun dengan email tersebut. Email hanya bisa
                    didaftarkan satu kali, sehingga email yang sudah terdaftar tidak akan bisa digunakan untuk mendaftar
                    ulang.</p>
                <p class="lead">Email yang tersimpan di dalam database tidak akan digunakan untuk tujuan komersil atau
                    tujuan lainnya. Kami akan berupaya untuk menjaga data supaya pengguna tetap merasa aman saat
                    mengakses platform Kelasbisa.</p>
                <p class="lead"><b>Penggunaan nama</b></p>
                <p class="lead">Kami tidak membatasi nama pengguna, artinya pengguna bisa bebas memberikan nama apa saja
                    ketika proses medaftar. Akan tetapi jika pengguna tersebut membeli kelas premium dan hendak
                    mendownload sertifikat, nama di sertifikat adalah nama yang didaftarkan. Nama pengguna akan disimpan
                    di database kami dan tidak akan kami komersialkan atau tujuan lainnya, murni hanya untuk
                    identifikasi dan pencetakan nama pada sertifikat.</p>
                <p class="lead"><b>Penggunaan password</b></p>
                <p class="lead">Password yang digunakan akan dienkripsi dan tidak akan diketahui oleh siapapun kecuali
                    pengguna yang memiliki password tersebut. Kami tidak membatasi penggunaan password, password bisa
                    berisi apa saja dan ketika sudah terdaftar akan dienkripsi sehingga tidak akan diketahui dan aman
                    terjaga.</p>
                <p class="lead"><b>Proses transaksi</b></p>
                <p class="lead">Proses konfirmasi transaksi tidak melalui platform Kelasbisa melainkan melalui nomor
                    whatsapp yang akan dikirimkan melalui email ketika pengguna hendak membeli kelas. Ketika sudah
                    melakukan transfer dengan mengirimkan bukti transfer, jangan diunggah di platform Kelasbisa, cukup
                    dikirimkan ke nomor yang telah disediakan dan kami tidak akan mengumpulkan baik nama maupun nomor
                    rekening pengguna. Konfirmasi pembayaran hanya untuk mengkonfirmasi bahwa pengguna sudah melakukan
                    pembelian kelas.</p>
            </div>
        </div>
    </div>
</div>
@endsection
