<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KPI Marketing</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Templates -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo_astra_square.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>

    <body>
        <!--  Body Wrapper -->
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="fixed" data-header-position="fixed">
            <!-- Sidebar Start -->
            <aside class="left-sidebar">
                <!-- Sidebar scroll-->
                <div>
                    <div class="brand-logo d-flex align-items-center justify-content-between">
                        <a href="./index.html" class="text-nowrap logo-img">
                            <img src="../assets/images/logos/logo_astra_final.png" width="180" alt="" />
                        </a>
                        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                            <i class="ti ti-x fs-8"></i>
                        </div>
                    </div>
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                        <ul id="sidebarnav">
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Home</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="./index.html" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-activity"></i>
                                    </span>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">ACTIVITY</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="./ui-buttons.html" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-list-details"></i>
                                    </span>
                                    <span class="hide-menu">Activity Plan</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="./ui-alerts.html" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-subtask"></i>
                                    </span>
                                    <span class="hide-menu">Initiatives</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">MARKETING</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('staff.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-users"></i>
                                    </span>
                                    <span class="hide-menu">Staff</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('div.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-divide"></i>
                                    </span>
                                    <span class="hide-menu">Divisi</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">LOGOUT</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <span>
                                        <i class="ti ti-logout"></i>
                                    </span>
                                    <span class="hide-menu">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!--  Sidebar End -->
            <!--  Main wrapper -->
            <div class="body-wrapper">
                <!--  Header Start -->
                <header class="app-header">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <ul class="navbar-nav">
                            <li class="nav-item d-block d-xl-none">
                                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                    href="javascript:void(0)">
                                    <i class="ti ti-menu-2"></i>
                                </a>
                            </li>
                            <li class="nav-item pt-3">
                                <h5>Hello, {{ Auth::user()->fullname }}!</h5>
                            </li>
                        </ul>
                        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                                <li class="nav-item pt-3">
                                    <h4>Manager</h4>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nav-icon-hover" href="" id="" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                                            class="rounded-circle">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <!--  Header End -->

                
                @yield('content')
            </div>
        </div>
        <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/sidebarmenu.js"></script>
        <script src="../assets/js/app.min.js"></script>
        <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
        <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
        <script src="../assets/js/dashboard.js"></script>
    </body>
</body>

</html>