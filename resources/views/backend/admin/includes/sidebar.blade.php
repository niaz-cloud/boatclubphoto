<!-- Unified Role-Based Sidebar -->

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            @role('Teacher')
                Teacher Panel
                @elserole('Student')
                Student Panel
            @else
                SMS Admin
            @endrole
        </a>

        <div class="sidebar-toggler">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">

            {{-- ================================================= --}}
            {{-- ================= ADMIN PANEL =================== --}}
            {{-- ================================================= --}}
            @role('Super Admin|Admin')

                {{-- Dashboard --}}
                <li class="nav-item nav-category">Dashboard</li>
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-chart-line"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>


                {{-- Admin Management --}}
                @role('Super Admin')
                    <li class="nav-item nav-category">Admin Management</li>

                    <li class="nav-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.admins.index') }}" class="nav-link">
                            <i class="fa-solid fa-user-shield"></i>
                            <span class="link-title">Admins Manage</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.role_permissions.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.role_permissions.index') }}" class="nav-link">
                            <i class="fa-solid fa-user-lock"></i>
                            <span class="link-title">Role Permissions</span>
                        </a>
                    </li>
                @endrole


                {{-- Student Management --}}
                <li class="nav-item nav-category">Student Management</li>

                <li class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.students.index') }}" class="nav-link">
                        <i class="fa-solid fa-user-graduate"></i>
                        <span class="link-title">Students</span>
                    </a>
                </li>


                {{-- Teacher Management (NEW) --}}
                <li class="nav-item nav-category">Teacher Management</li>

                <li class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.teachers.index') }}" class="nav-link">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        <span class="link-title">Teachers</span>
                    </a>
                </li>


                {{-- Classes --}}
                <li class="nav-item nav-category">Classes</li>

                <li class="nav-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.classes.index') }}" class="nav-link">
                        <i class="fa-solid fa-school"></i>
                        <span class="link-title">Classes</span>
                    </a>
                </li>


                {{-- Attendance --}}
                <li class="nav-item nav-category">Attendance</li>

                <li class="nav-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.attendance.index') }}" class="nav-link">
                        <i class="fa-solid fa-user-check"></i>
                        <span class="link-title">Attendance</span>
                    </a>
                </li>


                {{-- Exams --}}
                <li class="nav-item nav-category">Exams</li>

                <li class="nav-item {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.exams.index') }}" class="nav-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span class="link-title">Exams</span>
                    </a>
                </li>


                {{-- Results --}}
                <li class="nav-item nav-category">Results</li>

                <li class="nav-item {{ request()->routeIs('admin.results.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.results.index') }}" class="nav-link">
                        <i class="fa-solid fa-chart-column"></i>
                        <span class="link-title">Results</span>
                    </a>
                </li>


                {{-- Payments --}}
                <li class="nav-item nav-category">Payments</li>

                <li class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.payments.index') }}" class="nav-link">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <span class="link-title">Payments</span>
                    </a>
                </li>

            @endrole


            {{-- ================================================= --}}
            {{-- ================= SYSTEM SETTINGS =============== --}}
            {{-- ================================================= --}}
            @role('Super Admin')
                <li class="nav-item nav-category">System</li>

                <li class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}" class="nav-link">
                        <i class="fa-solid fa-gear"></i>
                        <span class="link-title">Settings</span>
                    </a>
                </li>
            @endrole


            {{-- ================================================= --}}
            {{-- ================= TEACHER PANEL ================= --}}
            {{-- ================================================= --}}
            @role('Teacher')
                <li class="nav-item nav-category">Dashboard</li>

                <li class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('teacher.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>


                <li class="nav-item nav-category">Students</li>

                <li class="nav-item {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}">
                    <a href="{{ route('teacher.students.index') }}" class="nav-link">
                        <i class="fa-solid fa-user-graduate"></i>
                        <span class="link-title">My Students</span>
                    </a>
                </li>


                <li class="nav-item nav-category">Attendance</li>

                <li class="nav-item {{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}">
                    <a href="{{ route('teacher.students.index') }}" class="nav-link">
                        <i class="fa-solid fa-user-check"></i>
                        <span class="link-title">Mark Attendance</span>
                    </a>
                </li>


                <li class="nav-item nav-category">Results</li>

                <li class="nav-item {{ request()->routeIs('teacher.results.*') ? 'active' : '' }}">
                    <a href="{{ route('teacher.students.index') }}" class="nav-link">
                        <i class="fa-solid fa-chart-column"></i>
                        <span class="link-title">Add Results</span>
                    </a>
                </li>
            @endrole


            {{-- ================================================= --}}
            {{-- ================= STUDENT PANEL ================= --}}
            {{-- ================================================= --}}
            @role('Student')
                <li class="nav-item nav-category">Dashboard</li>

                <li class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('student.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-house"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>


                <li class="nav-item {{ request()->routeIs('student.results') ? 'active' : '' }}">
                    <a href="{{ route('student.results') }}" class="nav-link">
                        <i class="fa-solid fa-chart-column"></i>
                        <span class="link-title">My Results</span>
                    </a>
                </li>


                <li class="nav-item {{ request()->routeIs('student.attendance') ? 'active' : '' }}">
                    <a href="{{ route('student.attendance') }}" class="nav-link">
                        <i class="fa-solid fa-user-check"></i>
                        <span class="link-title">My Attendance</span>
                    </a>
                </li>
            @endrole

        </ul>
    </div>
</nav>
