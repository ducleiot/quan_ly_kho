   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

       <!-- Sidebar - Brand -->
       <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin') }}">
           <div class="sidebar-brand-icon rotate-n-15">
               <i class="fas fa-laugh-wink"></i>
           </div>
           <div class="sidebar-brand-text mx-3">QUẢN LÝ KHO</div>
       </a>

       <!-- Divider -->
       <hr class="sidebar-divider my-0">

       <!-- Nav Item - Dashboard -->
       <li class="nav-item active">
           <a class="nav-link" href="{{ url('/admin') }}">
               <i class="fas fa-fw fa-tachometer-alt"></i>
               <span>Dashboard</span></a>
       </li>

       <!-- Divider -->
       <hr class="sidebar-divider">

       <!-- Heading -->
       <!-- <div class="sidebar-heading">
           QUẢN LÝ
       </div> -->

       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-ban-hang') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>BÁN HÀNG</span></a>
       </li>

       <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-nhap-hang') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>NHẬP HÀNG</span></a>
       </li>

       <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-so-luong') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>SỐ LƯỢNG</span>
           </a>
       </li>

       <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-san-pham') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>SẢN PHẨM</span>
           </a>
       </li>

        <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-loai-san-pham') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>LOẠI SẢN PHẨM</span>
           </a>
       </li>

       <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-loai-bao') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>LOẠI BAO</span>
           </a>
       </li>


        <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-mau-bao') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>MÀU BAO</span>
           </a>
       </li>

       <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-khach-hang') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>KHÁCH HÀNG</span>
           </a>
       </li>

       <?php if (auth()->user() != null && auth()->user()->level == 0) { ?>
       <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-tai-khoan') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>TÀI KHOẢN</span>
           </a>
       </li>
       <?php } ?>


        <?php if (auth()->user() != null && auth()->user()->level == 0) { ?>
       <li class="nav-item">
           <a class="nav-link" href="{{ url('admin/ql-thong-ke') }}">
               <!--i class="fas fa-fw fa-tasks"></i-->
               <span>THỐNG KÊ</span>
           </a>
       </li>
       <?php } ?>




       <!-- <li class="nav-item">
       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
         <i class="fas fa-fw fa-cog"></i>
         <span>Components</span>
       </a>
       <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
           <h6 class="collapse-header">Custom Components:</h6>
           <a class="collapse-item" href="buttons.html">Buttons</a>
           <a class="collapse-item" href="cards.html">Cards</a>
         </div>
       </div>
     </li-->

       <!-- Nav Item - Utilities Collapse Menu -->
       <!-- <li class="nav-item">
       <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
         <i class="fas fa-fw fa-wrench"></i>
         <span>Utilities</span>
       </a>
       <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
           <h6 class="collapse-header">Custom Utilities:</h6>
           <a class="collapse-item" href="utilities-color.html">Colors</a>
           <a class="collapse-item" href="utilities-border.html">Borders</a>
           <a class="collapse-item" href="utilities-animation.html">Animations</a>
           <a class="collapse-item" href="utilities-other.html">Other</a>
         </div>
       </div>
     </li> -->

       <!-- Divider -->
       {{-- <hr class="sidebar-divider"> --}}

       <!-- Heading -->
      {{--  <div class="sidebar-heading">
           Addons
       </div>

       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
           <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
               aria-expanded="true" aria-controls="collapsePages">
               <i class="fas fa-fw fa-folder"></i>
               <span>Pages</span>
           </a>
           <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
               <div class="bg-white py-2 collapse-inner rounded">
                   <h6 class="collapse-header">Login Screens:</h6>
                   <a class="collapse-item" href="login.html">Login</a>
                   <a class="collapse-item" href="register.html">Register</a>
                   <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                   <div class="collapse-divider"></div>
                   <h6 class="collapse-header">Other Pages:</h6>
                   <a class="collapse-item" href="404.html">404 Page</a>
                   <a class="collapse-item" href="blank.html">Blank Page</a>
               </div>
           </div>
       </li>

       <!-- Nav Item - Charts -->
       <li class="nav-item">
           <a class="nav-link" href="charts.html">
               <i class="fas fa-fw fa-chart-area"></i>
               <span>Charts</span></a>
       </li>

       <!-- Nav Item - Tables -->
       <li class="nav-item">
           <a class="nav-link" href="tables.html">
               <i class="fas fa-fw fa-table"></i>
               <span>Tables</span></a>
       </li> --}}

       <!-- Divider -->
       <hr class="sidebar-divider d-none d-md-block">

       <!-- Sidebar Toggler (Sidebar) -->
       <div class="text-center d-none d-md-inline">
           <button class="rounded-circle border-0" id="sidebarToggle"></button>
       </div>

       <!-- Sidebar Message -->
       {{-- <div class="sidebar-card">
       <img class="sidebar-card-illustration mb-2" src="{{asset('assets_admin/img/undraw_rocket.svg')}}" alt="">
       <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
       <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
     </div> --}}

   </ul>
   <!-- End of Sidebar -->
