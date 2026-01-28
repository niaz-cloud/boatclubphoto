<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>

    <div class="navbar-content">
        <ul class="navbar-nav">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    @if (Auth::user()->photo)
                        <img class="wd-30 ht-30 rounded-circle"
                             src="{{ asset(Auth::user()->photo) }}" alt="profile">
                    @else
                        <img class="wd-30 ht-30 rounded-circle"
                             src="{{ asset('backend_assets/images/user-dummy.png') }}" alt="profile">
                    @endif

                </a>

                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            @if (Auth::user()->photo)
                                <img class="wd-80 ht-80 rounded-circle"
                                     src="{{ asset(Auth::user()->photo) }}" alt="profile">
                            @else
                                <img class="wd-80 ht-80 rounded-circle"
                                     src="{{ asset('backend_assets/images/user-dummy.png') }}" alt="profile">
                            @endif
                        </div>

                        <div class="text-center">
                            <p class="tx-16 fw-bolder mb-0">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="tx-12 text-muted mb-0">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>

                    <ul class="list-unstyled p-1">

                        {{-- Profile --}}
                        <li class="dropdown-item py-2">
                            <a href="{{ route('admin.profile.edit') }}"
                               class="text-body ms-0 d-flex align-items-center">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>

                        {{-- Logout (POST) --}}
                        <li class="dropdown-item py-2">
                            <form method="POST" action="{{ route('admin.logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit"
                                        class="text-body ms-0 d-flex align-items-center w-100"
                                        style="background:none;border:none;padding:0;">
                                    <i class="me-2 icon-md" data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </li>

        </ul>
    </div>
</nav>
<!-- partial -->
