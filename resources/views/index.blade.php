@extends('layouts.home')
@section('page-header')
<div class="container shape-container d-flex align-items-center py-lg">
    <div class="col px-0">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <img src="{{ url('logo/logowhite.svg?') }}" alt="Logo kelasbisa" height="140" width="auto" class="mb-3">
                <h1 class="text-white display-1">Kelasbisa</h1>
                <p class="text-white" style="margin-top: -15px; font-size: 18px; font-weight: 600;">Siapapun Bisa!</p>
                <p class="lead font-weight-thin text-white">Kembangkan skill, kembangan diri, untuk masa depan lebih
                    baik.</p>
                <div class="btn-wrapper mt-4">
                    <a href="{{ url('login') }}" class="btn btn-warning btn-icon mt-3 mb-sm-0">
                        <span class="btn-inner--icon"><i class="ni ni-bold-right"></i></span>
                        <span class="btn-inner--text">Masuk Kelas</span>
                    </a>
                    <a href="{{ url('class') }}" class="btn btn-outline-secondary text-white btn-icon mt-3 mb-sm-0">
                        <span class="btn-inner--icon"><i class="ni ni-single-copy-04"></i></span>
                        <span class="btn-inner--text">Lihat Kelas</span>
                    </a>
                </div>
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
                <h3 class="display-3">Kenapa Memilih Kelas Bisa?</h3>
                <p class="lead">Jangan sia-siakan kesempatanmu. Orang-orang sudah bergabung.</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="info">
                    <div class="icon icon-lg icon-shape icon-shape-primary shadow rounded-circle">
                        <img src="{{ url('assets/icons/struktur.svg') }}" alt="" width="70">
                    </div>
                    <h6 class="info-title text-uppercase text-primary">Terstruktur</h6>
                    <p class="description opacity-8">Kelas di Kelas Bisa terstruktur dengan baik, sehingga Kamu akan
                        dibawa ke alur belajar yang tepat</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info">
                    <div class="icon icon-lg icon-shape icon-shape-danger shadow rounded-circle">
                        <img src="{{ url('assets/icons/uptodate.svg') }}" alt="" width="70">
                    </div>
                    <h6 class="info-title text-uppercase text-primary">Up-To-Date</h6>
                    <p class="description opacity-8">Kelas Bisa akan selau memberikan kelas yang up-to-date dan dapat
                        diterapkan di dunia kerja</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info">
                    <div class="icon icon-lg icon-shape icon-shape-success shadow rounded-circle">
                        <img src="{{ url('assets/icons/choices.svg') }}" alt="" width="70">
                    </div>
                    <h6 class="info-title text-uppercase text-primary">Beragam Pilihan</h6>
                    <p class="description opacity-8">Banyak pilihan kelas yang dapat diakses dari berbagai disiplin
                        ilmu, dan tentunya lebih murah dari kelas manapun.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section features-2 bg-gradient-blue text-white">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-md-4">
                <h3 class="text-white display-3">Apa saja yang ada di Kelas Bisa?</h3>
                <p>Kelas bisa menyediakan beragam fitur yang menarik</p>
            </div>
            <div class="col-md-8">
                <div class="row text-center">
                    <div class="col-md-3 mt-4"></div>
                    <div class="col-md-3 mt-4">
                        <div class="card">
                            <div class="card-body justify-content-center text-warning">
                                <img src="{{ url('assets/icons/sertificate.svg') }}" alt="" width="70" class="mb-3">
                                <h6>Sertifikat</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <div class="card">
                            <div class="card-body justify-content-center text-warning">
                                <img src="{{ url('assets/icons/videohd.svg') }}" alt="" width="70" class="mb-3">
                                <h6>Video HD</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <div class="card">
                            <div class="card-body justify-content-center text-warning">
                                <img src="{{ url('assets/icons/uptodate.svg') }}" alt="" width="70" class="mb-3">
                                <h6>Up-To-Date</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-3 mt-4"></div>
                    <div class="col-md-3 mt-4">
                        <div class="card">
                            <div class="card-body justify-content-center text-warning">
                                <img src="{{ url('assets/icons/modul.svg') }}" alt="" width="70" class="mb-3">
                                <h6>Modul</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <div class="card">
                            <div class="card-body justify-content-center text-warning">
                                <img src="{{ url('assets/icons/consul.svg') }}" alt="" width="70" class="mb-3">
                                <h6>Konsultasi</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <div class="card">
                            <div class="card-body justify-content-center text-warning">
                                <img src="{{ url('assets/icons/lifetime.svg') }}" alt="" width="70" class="mb-3">
                                <h6>Lifetime</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section features-1 my-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <h3 class="display-3 mb-3">Ayo Bergabung</h3>
                <p>Dan dapatkan semua fitur hanya dengan sekali pembayaran. Tersedia juga kelas gratis</p>
                <a href="{{ url('register') }}" class="btn btn-warning">Bergabung sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection
