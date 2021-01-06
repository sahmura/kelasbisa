<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Kelasbisa merupakan platform pengembangan skill dan ilmu baru kekinian dengan alur belajar yang terarah dan nyaman">
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

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('newtheme/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ url('newtheme/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('newtheme/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('newtheme/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('newtheme/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" type="text/css">

    @stack('css')

</head>

<body>
    <div class="topbar">
        @include('layouts.navbar')
    </div>
    <div class="page-wrapper-img">
        <div class="page-wrapper-img-inner">
            <div class="sidebar-user media">
                @if(Auth()->user()->profilpic != '')
                <img alt="Profil pic {{ Auth()->user()->name }}" src="{{ url('assets/profilpic/' . Auth()->user()->profilpic )}}" class="rounded-circle img-thumbnail mb-1">
                @else
                <img alt="Profil pic {{ Auth()->user()->name }}" src="{{ url('assets/image/userpic.svg')}}" class="rounded-circle img-thumbnail mb-1">
                @endif
                <span class="online-icon"><i class="mdi mdi-record text-success"></i></span>
                <div class="media-body">
                    <h5 class="text-light">{{ Auth()->user()->name }} </h5>
                    <ul class="list-unstyled list-inline mb-0 mt-2">
                        <li class="list-inline-item">
                            <a href="#" class=""><i class="mdi mdi-account text-light"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ url('setting') }}" class=""><i class="mdi mdi-settings text-light"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('logout') }}" class="" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="mdi mdi-power text-danger"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            @yield('header-body')
        </div>
    </div>

    <div class="page-wrapper">
        <div class="page-wrapper-inner">
            @yield('sidenav')
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>

                <footer class="footer text-center text-sm-left">
                    &copy; 2020 Kelasbisa <span class="text-muted d-none d-sm-inline-block float-right">Theme crafted with <i class="mdi mdi-heart text-danger"></i> by Mannatthemes</span>
                </footer>
            </div>
        </div>
    </div>

    <script src="{{ url('newtheme/js/jquery.min.js') }}"></script>
    <script src="{{ url('newtheme/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('newtheme/js/metisMenu.min.js') }}"></script>
    <script src="{{ url('newtheme/js/waves.min.js') }}"></script>
    <script src="{{ url('newtheme/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ url('newtheme/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    @stack('js')

</body>

</html>