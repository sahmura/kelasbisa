<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
                <!-- <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="..."> -->
                Kelas Bisa
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">

                    @if(Auth()->user()->role == 'user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('user') }}">
                            <i class="ni ni-app text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('user/myclass') }}">
                            <i class="ni ni-single-copy-04 text-success"></i>
                            <span class="nav-link-text">Kelas ku</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('user/class') }}">
                            <i class="ni ni-hat-3 text-danger"></i>
                            <span class="nav-link-text">List kelas</span>
                        </a>
                    </li>
                    @endif

                    @if(Auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('admin') }}">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text">Admin area</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/class') }}">
                            <i class="ni ni-collection text-orange"></i>
                            <span class="nav-link-text">Classes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/coupon') }}">
                            <i class="ni ni-key-25 text-primary"></i>
                            <span class="nav-link-text">Promo Code</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/category') }}">
                            <i class="ni ni-bullet-list-67 text-primary"></i>
                            <span class="nav-link-text">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/user') }}">
                            <i class="ni ni-single-02 text-yellow"></i>
                            <span class="nav-link-text">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/setting') }}">
                            <i class="ni ni-settings-gear-65 text-default"></i>
                            <span class="nav-link-text">Settings</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
