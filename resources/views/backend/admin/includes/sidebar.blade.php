<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            DBA<span>Clinic</span>
        </a>
        <div class="sidebar-toggler ">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">ADMIN</li>

            {{-- Dashboard --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item nav-category mt-3">ACCOUNTS PART</li>

         {{-- Room Manage Dropdown --}}
<li class="nav-item {{ in_array(($data['active_menu'] ?? ''), ['room_cat_add','room_cat_list']) ? 'active' : '' }}">
    <a class="nav-link" data-bs-toggle="collapse" href="#roomMenu" role="button"
       aria-expanded="false" aria-controls="roomMenu">
        <i class="fa-solid fa-bed"></i>
        <span class="link-title">Room Manage</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>

    <div class="collapse {{ in_array(($data['active_menu'] ?? ''), ['room_cat_add','room_cat_list']) ? 'show' : '' }}"
         id="roomMenu">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="{{ url('/admin/room-categories/add') }}" class="nav-link">Room Categories Add</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/room-categories/list') }}" class="nav-link">Room Categories List</a>
            </li>
        </ul>
    </div>
</li>


          {{-- Invoice Manage Dropdown --}}
<li class="nav-item {{ in_array(($data['active_menu'] ?? ''), ['invoice_add','checked_in_guest','due_list','full_paid_list','booked_list']) ? 'active' : '' }}">
    <a class="nav-link" data-bs-toggle="collapse" href="#invoiceMenu" role="button"
       aria-expanded="false" aria-controls="invoiceMenu">
        <i class="fa-solid fa-file-invoice"></i>
        <span class="link-title">Invoice Manage</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>

    <div class="collapse {{ in_array(($data['active_menu'] ?? ''), ['invoice_add','checked_in_guest','due_list','full_paid_list','booked_list']) ? 'show' : '' }}"
         id="invoiceMenu">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="{{ url('/admin/invoice-add') }}" class="nav-link">Invoice Add</a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin/checked-in-guest') }}" class="nav-link">Checked-in Guest</a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin/due-list') }}" class="nav-link">Due List</a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin/full-paid-list') }}" class="nav-link">Full Paid List</a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin/booked-list') }}" class="nav-link">Booked List</a>
            </li>
        </ul>
    </div>
</li>


            {{-- Payment List --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'payment_list' ? 'active' : '' }}">
                <a href="{{ url('/admin/payment-list') }}" class="nav-link">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span class="link-title">Payment List</span>
                </a>
            </li>

            {{-- Guests Manage --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'guests_manage' ? 'active' : '' }}">
                <a href="{{ url('/admin/guests-manage') }}" class="nav-link">
                    <i class="fa-solid fa-users"></i>
                    <span class="link-title">Guests Manage</span>
                </a>
            </li>

            {{-- Account Management --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'account_management' ? 'active' : '' }}">
                <a href="{{ url('/admin/account-management') }}" class="nav-link">
                    <i class="fa-solid fa-user-gear"></i>
                    <span class="link-title">Account Management</span>
                </a>
            </li>

            {{-- Report Management --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'report_management' ? 'active' : '' }}">
                <a href="{{ url('/admin/report-management') }}" class="nav-link">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span class="link-title">Report Management</span>
                </a>
            </li>

            {{-- Notification --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'notification' ? 'active' : '' }}">
                <a href="{{ url('/admin/notification') }}" class="nav-link">
                    <i class="fa-solid fa-bell"></i>
                    <span class="link-title">Notification</span>
                </a>
            </li>

            {{-- Pad Setting --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'pad_setting' ? 'active' : '' }}">
                <a href="{{ url('/admin/pad-setting') }}" class="nav-link">
                    <i class="fa-solid fa-sliders"></i>
                    <span class="link-title">Pad Setting</span>
                </a>
            </li>

            <li class="nav-item nav-category mt-3">WEBSITE PART</li>

            {{-- Slider --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'slider' ? 'active' : '' }}">
                <a href="{{ url('/admin/slider') }}" class="nav-link">
                    <i class="fa-solid fa-images"></i>
                    <span class="link-title">Slider</span>
                </a>
            </li>

            {{-- Common Pages --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'common_pages' ? 'active' : '' }}">
                <a href="{{ url('/admin/common-pages') }}" class="nav-link">
                    <i class="fa-solid fa-file-lines"></i>
                    <span class="link-title">Common Pages</span>
                </a>
            </li>

            {{-- Notices Manage --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'notices_manage' ? 'active' : '' }}">
                <a href="{{ url('/admin/notices-manage') }}" class="nav-link">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span class="link-title">Notices Manage</span>
                </a>
            </li>

            {{-- Staffs Manage --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'staffs_manage' ? 'active' : '' }}">
                <a href="{{ url('/admin/staffs-manage') }}" class="nav-link">
                    <i class="fa-solid fa-user-tie"></i>
                    <span class="link-title">Staffs Manage</span>
                </a>
            </li>

            {{-- Partners Manage --}}
            <li class="nav-item {{ ($data['active_menu'] ?? '') == 'partners_manage' ? 'active' : '' }}">
                <a href="{{ url('/admin/partners-manage') }}" class="nav-link">
                    <i class="fa-solid fa-handshake"></i>
                    <span class="link-title">Partners Manage</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
<!-- partial -->
