<!-- partial:partials/_sidebar.blade.php -->

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            SMS Admin<span></span>
        </a>

        <div class="sidebar-toggler">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">

            {{-- ================= DASHBOARD ================= --}}
            @can('view dashboard')
                <li class="nav-item nav-category">Dashboard</li>

                <li class="nav-item {{ ($data['active_menu'] ?? '') === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fa-solid fa-chart-line"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
            @endcan


            {{-- ================= ADMIN MANAGEMENT ================= --}}
            @can('manage admins')
                <li class="nav-item nav-category">Admin Management</li>

                <li class="nav-item has-sub {{ ($data['active_menu'] ?? '') === 'admins' ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#adminsMenu"
                        role="button">

                        <i class="fa-solid fa-user-shield"></i>
                        <span class="link-title ms-2">Admins Manage</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>

                    <div @class([
                        'collapse',
                        'show' => ($data['active_menu'] ?? '') === 'admins',
                    ]) id="adminsMenu">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('admin.admins.create') }}" class="nav-link">
                                    Admin Add
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.admins.index') }}" class="nav-link">
                                    Admin List
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan


            {{-- ================= ACCESS CONTROL ================= --}}
            @can('manage roles')
                <li class="nav-item nav-category">Access Control</li>

                <li class="nav-item {{ ($data['active_menu'] ?? '') === 'role_permissions' ? 'active' : '' }}">
                    <a href="{{ route('admin.role_permissions.index') }}" class="nav-link">
                        <i class="fa-solid fa-user-lock"></i>
                        <span class="link-title">Role Permissions</span>
                    </a>
                </li>
            @endcan


            {{-- ================= ATTENDANCE ================= --}}
            @can('manage attendance')
                <li class="nav-item nav-category">Attendance</li>

                <li class="nav-item has-sub {{ ($data['active_menu'] ?? '') === 'attendance' ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#attendanceMenu"
                        role="button">

                        <i class="fa-solid fa-user-check"></i>
                        <span class="link-title ms-2">Attendance</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>

                    <div @class([
                        'collapse',
                        'show' => ($data['active_menu'] ?? '') === 'attendance',
                    ]) id="attendanceMenu">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('admin.attendance.create') }}" class="nav-link">
                                    Mark Attendance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.attendance.index') }}" class="nav-link">
                                    Attendance List
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan


            {{-- ================= STUDENTS ================= --}}
            @can('manage students')
                <li class="nav-item nav-category">Student Management</li>

                <li class="nav-item has-sub {{ ($data['active_menu'] ?? '') === 'students' ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#studentsMenu"
                        role="button">

                        <i class="fa-solid fa-user-graduate"></i>
                        <span class="link-title ms-2">Students Manage</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>

                    <div @class([
                        'collapse',
                        'show' => ($data['active_menu'] ?? '') === 'students',
                    ]) id="studentsMenu">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('admin.students.create') }}" class="nav-link">
                                    Student Add
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.students.index') }}" class="nav-link">
                                    Student List
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan


            {{-- ================= CLASSES ================= --}}
            @can('manage classes')
                <li class="nav-item nav-category">Classes</li>

                <li class="nav-item has-sub {{ ($data['active_menu'] ?? '') === 'classes' ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#classesMenu"
                        role="button">

                        <i class="fa-solid fa-school"></i>
                        <span class="link-title ms-2">Classes Manage</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>

                    <div @class([
                        'collapse',
                        'show' => ($data['active_menu'] ?? '') === 'classes',
                    ]) id="classesMenu">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('admin.classes.create') }}" class="nav-link">
                                    Class Add
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.classes.index') }}" class="nav-link">
                                    Class List
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan


            {{-- ================= PAYMENTS ================= --}}
            @can('manage payments')
                <li class="nav-item nav-category">Payments</li>

                <li class="nav-item {{ ($data['active_menu'] ?? '') === 'payments' ? 'active' : '' }}">
                    <a href="{{ route('admin.payments.index') }}" class="nav-link">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <span class="link-title">Payments</span>
                    </a>
                </li>
            @endcan


            {{-- ================= EXAMS ================= --}}
            @can('manage exams')
                <li class="nav-item nav-category">Exams & Results</li>

                <li class="nav-item has-sub {{ ($data['active_menu'] ?? '') === 'exams' ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#examsMenu"
                        role="button">

                        <i class="fa-solid fa-clipboard-list"></i>
                        <span class="link-title ms-2">Exams Manage</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>

                    <div @class([
                        'collapse',
                        'show' => ($data['active_menu'] ?? '') === 'exams',
                    ]) id="examsMenu">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('admin.exams.create') }}" class="nav-link">
                                    Exam Add
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.exams.index') }}" class="nav-link">
                                    Exam List
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan


            {{-- ================= RESULTS ================= --}}
            @can('manage exams')
                <li class="nav-item nav-category">Results</li>

                <li class="nav-item has-sub {{ ($data['active_menu'] ?? '') === 'results' ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#resultsMenu"
                        role="button">
                        <i class="fa-solid fa-chart-column"></i>
                        <span class="link-title ms-2">Results Manage</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>

                    <div @class([
                        'collapse',
                        'show' => ($data['active_menu'] ?? '') === 'results',
                    ]) id="resultsMenu">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('admin.results.create') }}" class="nav-link">
                                    Result Add
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.results.index') }}" class="nav-link">
                                    Result List
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan

            {{-- ================= SETTINGS ================= --}}
            @can('manage settings')
                <li class="nav-item nav-category">Settings</li>

                <li class="nav-item {{ ($data['active_menu'] ?? '') === 'settings' ? 'active' : '' }}">
                    <a href="{{ url('/admin/settings') }}" class="nav-link">
                        <i class="fa-solid fa-gear"></i>
                        <span class="link-title">Settings</span>
                    </a>
                </li>
            @endcan

        </ul>
    </div>
</nav>

<!-- partial -->
