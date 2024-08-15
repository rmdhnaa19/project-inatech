<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fluks Aqua | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('voler-master/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('storage/asset_web/Logo Fluks Baru BG wth.png') }}" type="image/x-icon">
    @stack('css')

    <style>
        .table {
            width: 100% !important;
            margin-top: 20px !important;
            border-collapse: collapse !important;
        }

        .table th {
            background-color: #007BFF !important;
            font-weight: bold !important;
            padding: 10px !important;
            border-bottom: 2px solid #dee2e6 !important;
            color: white !important;
        }

        .table td {
            padding: 10px !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1 !important;
        }

        .table-bordered {
            border: 1px solid #dee2e6 !important;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }

        thead.thead-light th {
            background-color: #e9ecef !important;
            border-color: #dee2e6 !important;
        }

        .table th:first-child,
        .table td:first-child {
            border-top-left-radius: 5px !important;
            border-bottom-left-radius: 5px !important;
        }

        .table th:last-child,
        .table td:last-child {
            border-top-right-radius: 5px !important;
            border-bottom-right-radius: 5px !important;
        }
    </style>
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
