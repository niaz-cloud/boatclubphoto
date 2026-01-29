<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>{{ isset($data['page_title']) ? $data['page_title'] : 'Adv-Diary' }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css start -->
    <link rel="stylesheet" href="{{ asset('backend_assets/vendors/core/core.css') }}">
    <!-- core:css end -->

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('backend_assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend_assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">

    <!-- DataTables (LOCAL) -->
    <link rel="stylesheet" href="{{ asset('backend_assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">

    <!-- Date picker -->
    <link rel="stylesheet" href="{{ asset('backend_assets/vendors/flatpickr/flatpickr.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend_assets/vendors/select2/select2.min.css') }}">

    <!-- ✅ Global DataTable UI (matches screenshot) -->
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 18px;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            font-weight: 500;
            color: #475569;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
            padding: 7px 12px !important;
            outline: none !important;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
            padding: 6px 10px !important;
            outline: none !important;
        }

        table.dataTable.no-footer {
            border-bottom: 0 !important;
        }
    </style>

    {{-- Page specific CSS --}}
    @stack('css')

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('backend_assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('backend_assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend_assets/css/style.min.css') }}">
</head>

<body class="sidebar-dark">
    <script src="{{ asset('assets/js/loader.js') }}"></script>

    <div class="main-wrapper">
        @include('backend.admin.includes.sidebar')

        <div class="page-wrapper">
            @include('backend.admin.includes.header')

            @yield('content')

            @include('backend.admin.includes.footer')
        </div>
    </div>

    <!-- core:js -->
    <script src="{{ asset('backend_assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('backend_assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('backend_assets/js/bootstrap-maxlength.js') }}"></script>

    <!-- Icons -->
    <script src="{{ asset('backend_assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend_assets/js/template.js') }}"></script>

    <!-- Date picker -->
    <script src="{{ asset('backend_assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('backend_assets/js/flatpickr.js') }}"></script>

    <!-- DataTables (LOCAL) -->
    <script src="{{ asset('backend_assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('backend_assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>

    <!-- ✅ IMPORTANT: Remove this if it auto-initializes all tables -->
    {{-- <script src="{{ asset('backend_assets/js/data-table.js') }}"></script> --}}

    <!-- Select2 -->
    <script src="{{ asset('backend_assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('backend_assets/js/select2.js') }}"></script>

    {{-- Page specific JS --}}
    @stack('js')
</body>

</html>
