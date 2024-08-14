<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluks Aqua | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('storage/asset_web/Logo Fluks Baru BG wth.png') }}" type="image/x-icon">
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
    <script src="{{ asset('voler-master/dist/assets/js/vendors.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/main.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/bootstrap-4.0.0-dist/js/bootstrap.min.js') }}"></script>
</body>

</html>
