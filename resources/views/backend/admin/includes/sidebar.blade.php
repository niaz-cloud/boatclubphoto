<!-- partial:partials/_sidebar.blade.php -->

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            SMS<span></span>
        </a>

        {{-- ✅ NobleUI toggler (works with template.js) --}}
        <div class="sidebar-toggler">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">

            <li class="nav-item nav-category">Admin</li>

            {{-- Dashboard --}}
            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item nav-category">Student Management</li>

            {{-- Students --}}
            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'students') ? 'active' : '' }}">
                <a href="{{ route('admin.students.index') }}" class="nav-link">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span class="link-title">Students</span>
                </a>
            </li>

            {{-- Classes & Sections --}}
            <li class="nav-item {{ in_array(($data['active_menu'] ?? ''), ['class_add','class_list','section_add','section_list']) ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#classMenu" role="button"
                   aria-expanded="{{ in_array(($data['active_menu'] ?? ''), ['class_add','class_list','section_add','section_list']) ? 'true' : 'false' }}"
                   aria-controls="classMenu">
                    <i class="fa-solid fa-school"></i>
                    <span class="link-title">Classes & Sections</span>
                    <i class="fa-solid fa-chevron-down ms-auto"></i>
                </a>

                <div class="collapse {{ in_array(($data['active_menu'] ?? ''), ['class_add','class_list','section_add','section_list']) ? 'show' : '' }}"
                     id="classMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/admin/classes/add') }}" class="nav-link">Add Class</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/classes/list') }}" class="nav-link">Class List</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/sections/add') }}" class="nav-link">Add Section</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/sections/list') }}" class="nav-link">Section List</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Departments --}}
            <li class="nav-item {{ in_array(($data['active_menu'] ?? ''), ['dept_add','dept_list']) ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#deptMenu" role="button"
                   aria-expanded="{{ in_array(($data['active_menu'] ?? ''), ['dept_add','dept_list']) ? 'true' : 'false' }}"
                   aria-controls="deptMenu">
                    <i class="fa-solid fa-building-columns"></i>
                    <span class="link-title">Departments</span>
                    <i class="fa-solid fa-chevron-down ms-auto"></i>
                </a>

                <div class="collapse {{ in_array(($data['active_menu'] ?? ''), ['dept_add','dept_list']) ? 'show' : '' }}"
                     id="deptMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/admin/departments/add') }}" class="nav-link">Add Department</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/departments/list') }}" class="nav-link">Department List</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Academic</li>

            <li class="nav-item {{ in_array(($data['active_menu'] ?? ''), ['teacher_add','teacher_list']) ? 'active' : '' }}">
                <a href="{{ url('/admin/teachers') }}" class="nav-link">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span class="link-title">Teachers</span>
                </a>
            </li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'subjects') ? 'active' : '' }}">
                <a href="{{ url('/admin/subjects') }}" class="nav-link">
                    <i class="fa-solid fa-book"></i>
                    <span class="link-title">Subjects</span>
                </a>
            </li>

            <li class="nav-item nav-category">Attendance</li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'attendance') ? 'active' : '' }}">
                <a href="{{ url('/admin/attendance') }}" class="nav-link">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="link-title">Attendance</span>
                </a>
            </li>

            <li class="nav-item nav-category">Exams & Results</li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'exams') ? 'active' : '' }}">
                <a href="{{ url('/admin/exams') }}" class="nav-link">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span class="link-title">Exams</span>
                </a>
            </li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'results') ? 'active' : '' }}">
                <a href="{{ route('admin.results.index') }}" class="nav-link">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                    <span class="link-title">Results</span>
                </a>
            </li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'omr_errors') ? 'active' : '' }}">
                <a href="{{ route('admin.omr_errors.index') }}" class="nav-link">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span class="link-title">OMR Errors</span>
                </a>
            </li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'correct_answers') ? 'active' : '' }}">
                <a href="{{ route('admin.correct_answers.index') }}" class="nav-link">
                    <i class="fa-solid fa-check-double"></i>
                    <span class="link-title">Correct Answers</span>
                </a>
            </li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'auditors') ? 'active' : '' }}">
                <a href="{{ route('admin.auditors.index') }}" class="nav-link">
                    <i class="fa-solid fa-user-check"></i>
                    <span class="link-title">Auditors</span>
                </a>
            </li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'duplicate_rolls') ? 'active' : '' }}">
                <a href="{{ route('admin.duplicate-rolls.index') }}" class="nav-link">
                    <i class="fa-solid fa-copy"></i>
                    <span class="link-title">Duplicate Rolls</span>
                </a>
            </li>

            <li class="nav-item nav-category">Settings</li>

            <li class="nav-item {{ (($data['active_menu'] ?? '') == 'settings') ? 'active' : '' }}">
                <a href="{{ url('/admin/settings') }}" class="nav-link">
                    <i class="fa-solid fa-gear"></i>
                    <span class="link-title">Settings</span>
                </a>
            </li>

        </ul>
    </div>
</nav>

<!-- partial -->
