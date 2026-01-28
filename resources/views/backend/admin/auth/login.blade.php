<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Admin Login">
    <meta name="author" content="NobleUI">

    <title>Admin Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&amp;display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('backend_assets/vendors/core/core.css') }}">
    <!-- endinject -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend_assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend_assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('backend_assets/css/style.min.css') }}">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('backend_assets/images/favicon.png') }}" />

    <style>
        /* optional: if you want an image on left panel like screenshot */
        .auth-side-wrapper{
            background-image: url('{{ asset('backend_assets/images/login-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100%;
            min-height: 420px;
        }
    </style>
</head>

<body>
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pe-md-0">
                                <div class="auth-side-wrapper"></div>
                            </div>

                            <div class="col-md-8 ps-md-0">
                                <div class="auth-form-wrapper px-4 py-5">

                                    <a href="{{ url('/') }}" class="noble-ui-logo d-block mb-2">
                                        DBA<span>Clinic</span>
                                    </a>

                                    {{-- Session Error (Invalid credentials etc.) --}}
                                    @if(session('error'))
                                        <div class="alert alert-danger py-2 mb-2">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    {{-- Validation Errors --}}
                                    @if($errors->any())
                                        <div class="alert alert-danger py-2 mb-2">
                                            <ul class="mb-0 ps-3">
                                                @foreach($errors->all() as $err)
                                                    <li>{{ $err }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    {{-- ✅ IMPORTANT: submit to your ADMIN login route --}}
                                    <form class="forms-sample" action="{{ route('admin.login.submit') }}" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">Email address</label>
                                            <input
                                                type="email"
                                                value="{{ old('email') }}"
                                                name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="userEmail"
                                                placeholder="Email"
                                                required
                                            >
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-2">
                                            <label for="userPassword" class="form-label">Password</label>
                                            <input
                                                type="password"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="userPassword"
                                                autocomplete="current-password"
                                                placeholder="Password"
                                                required
                                            >
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <div class="mt-3">
                                                <input type="checkbox" class="form-check-input" id="showPass" onclick="show_password()">
                                                <label class="form-check-label" for="showPass">Show Password</label>
                                            </div>
                                        </div>

                                        {{-- simple "not robot" checkbox (client side) --}}
                                        <div class="form-check mb-3">
                                            <input
                                                type="checkbox"
                                                name="not_robot"
                                                class="form-check-input @error('not_robot') is-invalid @enderror"
                                                id="authCheck"
                                                required
                                            >
                                            <label class="form-check-label" for="authCheck">
                                                I am not robot
                                            </label>
                                            @error('not_robot')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-primary text-white me-2 mb-2 mb-md-0">
                                                Sign In
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- core:js -->
<script src="{{ asset('backend_assets/vendors/core/core.js') }}"></script>
<!-- endinject -->

<!-- inject:js -->
<script src="{{ asset('backend_assets/vendors/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('backend_assets/js/template.js') }}"></script>
<!-- endinject -->

<script>
    function show_password(){
        var input = document.getElementById('userPassword');
        input.type = (input.type === 'password') ? 'text' : 'password';
    }
</script>
</body>
</html>
