<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Panel</title>

    {{-- NobleUI / Bootstrap Core CSS --}}
    <link rel="stylesheet" href="{{ asset('backend_assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('backend_assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend_assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('backend_assets/css/all.min.css') }}">

    <style>
        body {
            background: #f1f5f9;
        }

        .content-area {
            padding: 25px;
        }
    </style>
</head>

<body class="sidebar-dark">

<div class="main-wrapper">

    {{-- Student Sidebar --}}
    @include('backend.student.includes.student_sidebar')

    <div class="page-wrapper">

        {{-- Student Header (optional) --}}
        @include('backend.student.includes.student_header')

        <div class="page-content content-area">
            @yield('content')
        </div>

    </div>
</div>

{{-- Core JS --}}
<script src="{{ asset('backend_assets/vendors/core/core.js') }}"></script>
<script src="{{ asset('backend_assets/vendors/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('backend_assets/js/template.js') }}"></script>

@stack('scripts')

</body>
</html>
