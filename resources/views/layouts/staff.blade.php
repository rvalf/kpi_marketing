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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js is required) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Numeral JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <!-- Templates -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo_astra_square.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />

    <style>
    .table .bg-success th,
    .table .bg-success td {
        color: white;
    }

    .border-grey {
        border: solid 1px #e3e3e3;
    }

    p.sub-title {
        font-size: 10px;
        margin-bottom: 2px;
        text-decoration: underline;
    }

    .table-detail th,
    .table-detail td {
        font-size: 13px;
    }

    .table-detail th {
        padding-bottom: 0;
        padding-top: 0;
    }

    .dropdown button::after {
        content: none;
    }

    .font-11 .col {
        font-size: 11px;
    }

    .report-link:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    </style>
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
                                <a class="sidebar-link" href="{{ route('home') }}" aria-expanded="false">
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
                                <a class="sidebar-link" href="{{ route('report.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-clipboard-text"></i>
                                    </span>
                                    <span class="hide-menu">Performance Report</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('init.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-subtask"></i>
                                    </span>
                                    <span class="hide-menu">Initiatives</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('act.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-list-details"></i>
                                    </span>
                                    <span class="hide-menu">Activity Plan</span>
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
                                <h5>Depatment {{ Auth::user()->divisi->name }}</h5>
                            </li>
                        </ul>
                        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                                <li class="nav-item pt-3">
                                    <h5>{{ Auth::user()->fullname }}</h5>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35"
                                            height="35" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                        aria-labelledby="drop2">
                                        <div class="message-body">
                                            <a href="{{ route('staff.showprofile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                                                <i class="ti ti-user fs-6"></i>
                                                <p class="mb-0 fs-3">My Profile</p>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <!--  Header End -->

                @yield('content')

            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
        <script src="{{ asset('assets/js/dashboard.js') }}"></script>

        <script>
        $(document).ready(function() {
            $('.show-detail').on('click', function(e) {
                e.preventDefault();
                var parentCard = $(this).closest('.card-body');
                parentCard.find('.details').slideToggle();
                return false;
            });

            var hasilPresentaseElements = document.querySelectorAll('.hasil-presentase');

            // Loop melalui setiap elemen hasil-presentase dan hitung serta set nilai persentase pencapaian
            hasilPresentaseElements.forEach(function(element, index) {
                var planning = parseFloat(document.querySelectorAll('.planning')[index].textContent);
                var actual = parseFloat(document.querySelectorAll('.aktual')[index].textContent);

                // Menghitung persentase pencapaian dan membulatkannya ke bilangan bulat
                var hasilPencapaian = Math.round((actual / planning) * 100);

                // Menampilkan hasil di dalam elemen hasil-presentase
                element.textContent = hasilPencapaian + ' %';
            });

            var elements = document.getElementsByClassName('formattedValue');

            // Iterate over each element and format its content
            for (var i = 0; i < elements.length; i++) {
                var rawValue = parseInt(elements[i].innerText); // Parse the value as an integer

                // Use Numeral.js to format the value
                var formattedValue;

                if (rawValue >= 1000000000) {
                    formattedValue = numeral(rawValue / 1000000000).format('0.0a').toUpperCase() + 'B';
                } else if (rawValue >= 1000000) {
                    formattedValue = numeral(rawValue / 1000000).format('0.0a').toUpperCase() + 'M';
                } else if (rawValue >= 1000) {
                    formattedValue = numeral(rawValue / 1000).format('0.0a').toUpperCase() + 'K';
                } else {
                    formattedValue = rawValue;
                }
            
                // Update the element with the formatted value
                elements[i].innerText = formattedValue;
            }
        });
        </script>
    </body>
</body>

</html>