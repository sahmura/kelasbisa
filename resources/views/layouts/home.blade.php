<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Kelas Bisa
    </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="{{ url('assets/home/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/home/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/home/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/home/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/home/css/argon-design-system.css?v=1.2.0') }}" rel="stylesheet" />
</head>

<body class="landing-page">
    @include('layouts.navbarhome')
    <div class="wrapper">
        <div class="section section-hero section-shaped">
            <div class="shape shape-style-1 shape-primary">
                <span class="span-150"></span>
                <span class="span-50"></span>
                <span class="span-50"></span>
                <span class="span-75"></span>
                <span class="span-100"></span>
                <span class="span-75"></span>
                <span class="span-50"></span>
                <span class="span-100"></span>
                <span class="span-50"></span>
                <span class="span-100"></span>
            </div>
            <div class="page-header">
                @yield('page-header')
                <div class="separator separator-bottom separator-skew zindex-100">
                    <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                        xmlns="http://www.w3.org/2000/svg">
                        <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
                    </svg>
                </div>
            </div>
        </div>
        @yield('content')
        <footer class="footer">
            <div class="container">
                <div class="row py-5">
                    <div class="col-md-4">
                        <h3>Kelas Bisa</h3>
                        <p>Tempat pengembangan skill dan ilmu baru. Kelas
                            terstruktur untuk berbagai kalangan. Tersedia beragam tingkat mulai dari pemula hingga
                            mahir.</p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">
                                <h5>Bantuan</h5>
                                <a href="{{ url('about') }}">Tentang kami</a><br>
                                <a href="{{ url('howto') }}">Cara pembayaran</a><br>
                                <a href="{{ url('class') }}">Daftar kelas</a><br>
                                <a href="{{ url('privacy') }}">Kebijakan privasi</a><br>
                            </div>
                            <div class="col">
                                <h5>Hubungi kami</h5>
                                <p>id.khoerulumam@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center py-3">
                    <div class="col-md-12">
                        &copy;2020 Kelas Bisa. All rights reserved. Giving with love &hearts;
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ url('assets/home/js/core/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/home/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/home/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/home/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ url('assets/home/js/plugins/nouislider.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/home/js/plugins/moment.min.js') }}"></script>
    <script src="{{ url('assets/home/js/plugins/datetimepicker.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/home/js/plugins/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ url('assets/home/js/argon-design-system.min.js?v=1.2.0') }}" type="text/javascript"></script>

    @stack('js')
</body>

</html>
