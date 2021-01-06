 <div class="left-sidenav">

     <ul class="metismenu left-sidenav-menu" id="side-nav">

         @if(Auth()->user()->role == 'user')
         <li class="menu-title">Dashboard</li>

         <li>
             <a class="nav-link" id="sidebar-user" href="{{ url('user') }}">
                 <i class="mdi mdi-desktop-mac"></i>
                 <span class="nav-link-text">Beranda</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-myclass" href="{{ url('user/myclass') }}">
                 <i class="mdi mdi-book-outline"></i>
                 <span class="nav-link-text">Kelas Saya</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-class" href="{{ url('user/class') }}">
                 <i class="mdi mdi-wunderlist"></i>
                 <span class="nav-link-text">Daftar Kelas</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-certificate" href="{{ url('user/certificate') }}">
                 <i class="mdi mdi-trophy-variant-outline"></i>
                 <span class="nav-link-text">Sertifikat</span>
             </a>
         </li>
         @endif

         @if(Auth()->user()->role == 'admin')
         <li class="menu-title">Admin</li>
         <li>
             <a class="nav-link" id="sidebar-admin" href="{{ url('admin') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Admin area</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-statistic" href="{{ url('admin/statistic') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Statistic</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-class" href="{{ url('admin/class') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Classes</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-speaker" href="{{ url('admin/speaker') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Speaker</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-coupon" href="{{ url('admin/coupon') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Promo Code</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-coupon" href="{{ url('admin/transaction') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Transaction</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-agenda" href="{{ url('admin/agenda') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Agenda</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-category" href="{{ url('admin/category') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Categories</span>
             </a>
         </li>
         <li>
             <a class="nav-link" id="sidebar-user" href="{{ url('admin/user') }}">
                 <i class="mdi mdi-lock-outline"></i>
                 <span class="nav-link-text">Users</span>
             </a>
         </li>
         @endif
         <li>
             <a class="nav-link" id="sidebar-setting" href="{{ url('setting') }}">
                 <i class="mdi mdi-settings-outline"></i>
                 <span class="nav-link-text">Pengaturan</span>
             </a>
         </li>
     </ul>
 </div>
 @push('js')
 <script>
     $(document).ready(function() {
         var currenturl = "{{ request()->segment(count(request()->segments())) }}";
         $('#sidebar-' + currenturl).addClass('active');
     });
 </script>
 @endpush