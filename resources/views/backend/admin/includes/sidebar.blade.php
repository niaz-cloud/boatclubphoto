<!-- partial:partials/_sidebar.blade.php -->

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            SMS Admin<span></span>
        </a>

        {{-- NobleUI toggler --}}
        <div class="sidebar-toggler">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">

            {{-- ================= ADMIN ================= --}}
            <li class="nav-item nav-category">Admin</li>

            {{-- Dashboard --}}
            <li class="nav-item {{ (($data['active_menu'] ?? '') === 'dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            {{-- ================= ADMIN MANAGEMENT (SUPER ADMIN ONLY) ================= --}}
            @if(auth()->user()->role === 'super_admin')
                <li class="nav-item nav-category">Admin Management</li>

                <li class="nav-item has-sub {{ (($data['active_menu'] ?? '') === 'admins') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center"
                       data-bs-toggle="collapse"
                       href="#adminsMenu"
                       role="button"
                       aria-expanded="{{ (($data['active_menu'] ?? '') === 'admins') ? 'true' : 'false' }}"
                       aria-controls="adminsMenu">

                        <i class="fa-solid fa-user-shield"></i>
                        <span class="link-title ms-2">Admins Manage</span>
                        <i class="fa-solid fa-chevron-down ms-auto"></i>
                    </a>

                    <div @class(['collapse', 'show' => (($data['active_menu'] ?? '') === 'admins')]) id="adminsMenu">
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
            @endif

            {{-- ================= STUDENT MANAGEMENT ================= --}}
            <li class="nav-item nav-category">Student Management</li>

            <li class="nav-item has-sub {{ (($data['active_menu'] ?? '') === 'students') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center"
                   data-bs-toggle="collapse"
                   href="#studentsMenu"
                   role="button"
                   aria-expanded="{{ (($data['active_menu'] ?? '') === 'students') ? 'true' : 'false' }}"
                   aria-controls="studentsMenu">

                    <i class="fa-solid fa-user-graduate"></i>
                    <span class="link-title ms-2">Students Manage</span>
                    <i class="fa-solid fa-chevron-down ms-auto"></i>
                </a>

                <div @class(['collapse', 'show' => (($data['active_menu'] ?? '') === 'students')]) id="studentsMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.students.create') }}" class="nav-link">Student Add</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.students.index') }}" class="nav-link">Student List</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ================= CLASSES ================= --}}
            <li class="nav-item has-sub {{ (($data['active_menu'] ?? '') === 'classes') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center"
                   data-bs-toggle="collapse"
                   href="#classesMenu"
                   role="button"
                   aria-expanded="{{ (($data['active_menu'] ?? '') === 'classes') ? 'true' : 'false' }}"
                   aria-controls="classesMenu">

                    <i class="fa-solid fa-school"></i>
                    <span class="link-title ms-2">Classes Manage</span>
                    <i class="fa-solid fa-chevron-down ms-auto"></i>
                </a>

                <div @class(['collapse', 'show' => (($data['active_menu'] ?? '') === 'classes')]) id="classesMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.classes.create') }}" class="nav-link">Class Add</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.classes.index') }}" class="nav-link">Class List</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ================= EXAMS ================= --}}
            <li class="nav-item nav-category">Exams & Results</li>

            <li class="nav-item has-sub {{ (($data['active_menu'] ?? '') === 'exams') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center"
                   data-bs-toggle="collapse"
                   href="#examsMenu"
                   role="button"
                   aria-expanded="{{ (($data['active_menu'] ?? '') === 'exams') ? 'true' : 'false' }}"
                   aria-controls="examsMenu">

                    <i class="fa-solid fa-clipboard-list"></i>
                    <span class="link-title ms-2">Exams Manage</span>
                    <i class="fa-solid fa-chevron-down ms-auto"></i>
                </a>

                <div @class(['collapse', 'show' => (($data['active_menu'] ?? '') === 'exams')]) id="examsMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.exams.create') }}" class="nav-link">Exam Add</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.exams.index') }}" class="nav-link">Exam List</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ================= RESULTS ================= --}}
            <li class="nav-item has-sub {{ (($data['active_menu'] ?? '') === 'results') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center"
                   data-bs-toggle="collapse"
                   href="#resultsMenu"
                   role="button"
                   aria-expanded="{{ (($data['active_menu'] ?? '') === 'results') ? 'true' : 'false' }}"
                   aria-controls="resultsMenu">

                    <i class="fa-solid fa-square-poll-vertical"></i>
                    <span class="link-title ms-2">Results Manage</span>
                    <i class="fa-solid fa-chevron-down ms-auto"></i>
                </a>

                <div @class(['collapse', 'show' => (($data['active_menu'] ?? '') === 'results')]) id="resultsMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.results.create') }}" class="nav-link">Result Add</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.results.index') }}" class="nav-link">Result List</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ================= OTHERS ================= --}}
            <li class="nav-item {{ (($data['active_menu'] ?? '') === 'omr_errors') ? 'active' : '' }}">
                <a href="{{ route('admin.omr_errors.index') }}" class="nav-link">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span class="link-title">OMR Errors</span>
                </a>
            </li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') === 'correct_answers') ? 'active' : '' }}">
                <a href="{{ route('admin.correct_answers.index') }}" class="nav-link">
                    <i class="fa-solid fa-check-double"></i>
                    <span class="link-title">Correct Answers</span>
                </a>
            </li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') === 'auditors') ? 'active' : '' }}">
                <a href="{{ route('admin.auditors.index') }}" class="nav-link">
                    <i class="fa-solid fa-user-check"></i>
                    <span class="link-title">Auditors</span>
                </a>
            </li>

            {{-- ================= SETTINGS ================= --}}
            <li class="nav-item nav-category">Settings</li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') === 'settings') ? 'active' : '' }}">
                <a href="{{ url('/admin/settings') }}" class="nav-link">
                    <i class="fa-solid fa-gear"></i>
                    <span class="link-title">Settings</span>
                </a>
            </li>

        </ul>
    </div>
</nav>

<!-- partial -->
