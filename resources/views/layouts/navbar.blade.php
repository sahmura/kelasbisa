<nav class="navbar-custom">
    <div class="topbar-left">
        <a href="{{ url('') }}" class="logo">
            <span>
                <img src="{{ url('logo/logocolor.svg?') }}" alt="logo-small" class="logo-sm" style="height:40px">
            </span>
            <span>
                <img src="{{ url('logo/textcolor.svg?') }}" alt="logo-large" class="logo-lg" style="height:20px">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topbar-nav float-right mb-0">

        <!-- <li class="dropdown">
            <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="mdi mdi-bell-outline nav-icon"></i>
                <span class="badge badge-danger badge-pill noti-icon-badge">2</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                <h6 class="dropdown-item-text">
                    Notifications (258)
                </h6>
                <div class="slimscroll notification-list">
                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                        <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                        <p class="notify-details">Your order is placed<small class="text-muted">Dummy text of the printing and typesetting industry.</small></p>
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-warning"><i class="mdi mdi-message"></i></div>
                        <p class="notify-details">New Message received<small class="text-muted">You have 87 unread messages</small></p>
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-info"><i class="mdi mdi-glass-cocktail"></i></div>
                        <p class="notify-details">Your item is shipped<small class="text-muted">It is a long established fact that a reader will</small></p>
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                        <p class="notify-details">Your order is placed<small class="text-muted">Dummy text of the printing and typesetting industry.</small></p>
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-danger"><i class="mdi mdi-message"></i></div>
                        <p class="notify-details">New Message received<small class="text-muted">You have 87 unread messages</small></p>
                    </a>
                </div>
                <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                    View all <i class="fi-arrow-right"></i>
                </a>
            </div>
        </li> -->

        <li class="dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                @if(Auth()->user()->profilpic != '')
                <img alt="Profil pic {{ Auth()->user()->name }}" src="{{ url('assets/profilpic/' . Auth()->user()->profilpic )}}" class="rounded-circle">
                @else
                <img alt="Profil pic {{ Auth()->user()->name }}" src="{{ url('assets/image/userpic.svg')}}" class="rounded-circle">
                @endif
                <span class="ml-1 nav-user-name hidden-sm"> <i class="mdi mdi-chevron-down"></i> </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="dripicons-exit text-muted mr-2"></i> Logout</a>
            </div>
        </li>
    </ul>

    <ul class="list-unstyled topbar-nav mb-0">
        <li>
            <button class="button-menu-mobile nav-link waves-effect waves-light">
                <i class="mdi mdi-menu nav-icon"></i>
            </button>
        </li>

        <!-- <li class="hide-phone app-search">
            <form role="search" class="">
                <input type="text" placeholder="Search..." class="form-control">
                <a href=""><i class="fas fa-search"></i></a>
            </form>
        </li> -->
    </ul>

</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>