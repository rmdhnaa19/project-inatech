<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fluks Aqua | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
    <link rel="stylesheet"
        href="{{ asset('voler-master/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('storage/asset_web/Logo Fluks Baru BG wth.png') }}" type="image/x-icon">
    <!-- Load DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/vendors/choices.js/choices.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/kelolaPengguna.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manajemenKolam.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manajemenTambak.css') }}">
    <link rel="stylesheet" href="{{ asset('css/faseKolam.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pjTambak.css') }}">
    @stack('css')
</head>

<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                @include('layouts.sidebar')
            </div>
        </div>
        <div id="main">
            @include('layouts.header')
            <div class="main-content container-fluid">
                <div class="page-title">
                    @include('layouts.breadcrumb')
                </div>
                <section class="section">
                    @yield('content')
                </section>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    @include('layouts.footer')
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('voler-master/dist/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('voler-master/src/assets/js/app.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="{{ asset('voler-master/dist/assets/js/vendors.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/main.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/bootstrap-4.0.0-dist/js/bootstrap.min.js') }}"></script>
    <!-- Load jQuery (versi yang Anda gunakan) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Load DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://kit.fontawesome.com/75f7078132.js" crossorigin="anonymous"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/choices.js/choices.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('js')
</body>

</html>