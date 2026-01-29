<!-- partial:partials/_sidebar.blade.php -->

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            SMS Admin<span></span>
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
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'classes' ? 'active' : '' }}">
    <a href="{{ route('admin.classes.index') }}" class="nav-link">
        <span>
            <i class="fa-solid fa-school"></i>
            <span class="link-title">Classes</span>
        </span>
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
