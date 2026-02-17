<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            Student Panel
        </a>

        <div class="sidebar-toggler">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">

            {{-- STUDENT --}}
            <li class="nav-item nav-category">Student</li>

            {{-- Dashboard --}}
            <li class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <a href="{{ route('student.dashboard') }}" class="nav-link">
                    <i class="fa-solid fa-house"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            {{-- Results --}}
            <li class="nav-item {{ request()->routeIs('student.results') ? 'active' : '' }}">
                <a href="{{ route('student.results') }}" class="nav-link">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                    <span class="link-title">My Results</span>
                </a>
            </li>

            {{-- Attendance --}}
            <li class="nav-item {{ request()->routeIs('student.attendance') ? 'active' : '' }}">
                <a href="{{ route('student.attendance') }}" class="nav-link">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="link-title">My Attendance</span>
                </a>
            </li>

            {{-- Profile --}}
            <li class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                <a href="{{ route('student.profile') }}" class="nav-link">
                    <i class="fa-solid fa-user"></i>
                    <span class="link-title">My Profile</span>
                </a>
            </li>

            {{-- Logout --}}
            <li class="nav-item mt-3">
               <form method="POST" action="{{ route('logout') }}">

                    @csrf
                    <button class="nav-link btn btn-link text-danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="link-title">Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</nav>
