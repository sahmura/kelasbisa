<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Kelasbisa merupakan platform pengembangan skill dan ilmu baru kekinian dengan alur belajar yang terarah dan nyaman">
    <meta name="author" content="Kelasbisa">
    <title>Kelasbisa @yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <meta name="msapplication-TileColor" content="#5e72e4">
    <meta name="msapplication-TileImage" content="{{ url('ms-icon-144x144.png?') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="mobile-web-app-capable" content="yes">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ url('assets/argon/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <link rel="stylesheet" href="{{ url('assets/argon/css/argon.css?v=1.2.0') }}" type="text/css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" type="text/css">

    @stack('css')
</head>

<body>
    @include('layouts.sidebar')
    <div class="main-content" id="panel">
        @include('layouts.topnav')
        <div class="header @yield('bg-header') pb-6" @stack('style-header')>
            <div class="container-fluid">
                <div class="header-body">
                    @if(Auth()->user()->email_verified_at == null)
                    <div class="row pt-3">
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h3 class="text-danger">Konfirmasi email!</h3>
                                    <p>Email belum dikonfirmasi, harap konfirmasi email terlebih dahulu</p>
                                    <a href="{{ url('user/confirm-email') }}" class="btn btn-success">Kirim email
                                        verifikasi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @yield('header-body')
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="{{ asset('assets/argon/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/argon/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <script src="{{ asset('assets/argon/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/argon/vendor/chart.js/dist/Chart.extension.js') }}"></script>
    <script src="{{ asset('assets/argon/js/argon.js?v=1.2.0') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register("{{ url('sw.js') }}").then(function (
                    registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration
                        .scope);
                }, function (err) {
                    // registration failed :(
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }

    </script>
    @stack('js')

</body>

</html>
