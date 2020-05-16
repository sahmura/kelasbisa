<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Kelasbisa merupakan platform pengembangan skill dan ilmu baru kekinian dengan alur belajar yang terarah dan nyaman">
    <meta name="author" content="Kelasbisa">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Kelasbisa
    </title>

    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('apple-icon-57x57.png?') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('apple-icon-60x60.png?') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('apple-icon-72x72.png?') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('apple-icon-76x76.png?') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('apple-icon-114x114.png?') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('apple-icon-120x120.png?') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('apple-icon-144x144.png?') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('apple-icon-152x152.png?') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('apple-icon-180x180.png?') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ url('android-icon-192x192.png?') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon-32x32.png?') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('favicon-96x96.png?') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon-16x16.png?') }}">
    <link rel="manifest" href="{{ url('manifest.json?')}}">
    <link rel="manifest" href="{{ url('manifest.webmanifest')}}">
    <meta name="msapplication-TileColor" content="#5e72e4">
    <meta name="msapplication-TileImage" content="{{ url('ms-icon-144x144.png?') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="mobile-web-app-capable" content="yes">

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
            <div class="shape shape-style-3 shape-default">
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
            </div>
        </div>
        @yield('content')
        <footer class="footer">
            <div class="container">
                <div class="row py-5">
                    <div class="col-md-4">
                        <h3>Kelasbisa</h3>
                        <p>Tempat pengembangan skill dan ilmu baru. Kelas
                            terstruktur untuk berbagai kalangan. Tersedia beragam tingkat mulai dari pemula hingga
                            mahir.</p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">
                                <h5>Bantuan</h5>
                                <p><i class="ni ni-bold-right"></i> <a href="{{ url('about') }}">Tentang kami</a></p>
                                <p><i class="ni ni-bold-right"></i> <a href="{{ url('howto') }}">Cara pembayaran</a></p>
                                <p><i class="ni ni-bold-right"></i> <a href="{{ url('class') }}">Daftar kelas</a></p>
                                <p><i class="ni ni-bold-right"></i> <a href="{{ url('privacy') }}">Kebijakan privasi</a>
                                </p>
                            </div>
                            <div class="col">
                                <h5>Hubungi kami</h5>
                                <p>admin@kelasbisa.my.id</p>
                                <h5>Icons</h5>
                                <p><a href="https://www.flaticon.com/authors/itim2101">itim2101</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center py-3">
                    <div class="col-md-12">
                        &copy;2020 Kelasbisa. All rights reserved. Giving with love &hearts;
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
