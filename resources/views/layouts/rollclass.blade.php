<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Kelasbisa @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ url('assets/argon/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <link rel="stylesheet" href="{{ url('assets/argon/css/argon.css?v=1.2.0') }}" type="text/css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" type="text/css">

    @stack('css')
</head>

<body>
    @yield('sidebarroll')
    <div class="main-content" id="panel">
        @include('layouts.topnav')
        <div class="header @yield('bg-header') pb-6" @yield('style-header')>
            <div class="container-fluid">
                <div class="header-body">
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


    @stack('js')

</body>

</html>
