<!-- resources/views/layouts/main.blade.php -->
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Fonts for this template-->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/fontawesome.min.css" rel="stylesheet">

    <!-- Custom Styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables-demo.js') }}"></script>

    <style>
        /* Hiding the dropdown arrow */
        .dropdown-toggle::after {
            display: none;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-hospital-user"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Klinik Fisioterapi Gerhana<sup></sup></div><br>
            </a>
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                @if(Auth::check())
                    @if(Auth::user()->role == 'admin')
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role == 'fisioterapis')
                        <a class="nav-link" href="{{ route('fisioterapis.dashboard') }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role == 'pasien')
                        <a class="nav-link" href="{{ route('pasien.dashboard') }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif
                @endif
            </li>


            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Menu untuk role Admin -->
            @if (Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-pasien.index') }}">
                        <i class="fas fa-fw fas fa-user-md"></i>
                        <span>Data Pasien</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-fisioterapis.index') }}">
                        <i class="fas fa-fw fas fa-user-md"></i>
                        <span>Data Fisioterapis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-antrian.index') }}">
                        <i class="fas fa-fw fas fa-user-md"></i>
                        <span>Data Antrian</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-rekam-medis.index') }}">
                        <i class="fas fa-fw fas fa-user-md"></i>
                        <span>Data Rekam Medis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.riwayat.index') }}">
                        <i class="fas fa-fw fas fa-user-md"></i>
                        <span>Riwayat Terapi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-user.index') }}">
                        <i class="fas fa-fw fas fa-user-md"></i>
                        <span>Data Akun</span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'pasien')
                <!-- Menu untuk Pasien -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('riwayat-terapi.index') }}">
                        <i class="fas fa-fw fas fa-user"></i>
                        <span>Data Terapi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.show') }}">
                        <i class="fas fa-fw fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
            @elseif (Auth::user()->role == 'fisioterapis')
                <!-- Menu untuk Fisioterapis -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fisioterapis.rekam_medis.index') }}">
                        <i class="fas fa-fw fas fa-user-md"></i>
                        <span>Data Rekam Medis</span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('fisioterapis.profile.show') }}">
                        <i class="fas fa-fw fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                
                </li>
            @endif

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div class="container-fluid">
                @yield('content') <!-- Konten halaman -->
            </div>

            <!-- Footer -->
            @include('layouts.footer') <!-- Panggil footer disini -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>

</html>
