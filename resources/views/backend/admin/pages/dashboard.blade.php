@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <h6 class="card-title mb-3">Welcome To Dashboard</h6>

            <div class="row">

                {{-- Row 1: 4 room cards --}}
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase">Single Room</h6>

                            <div style="font-size:18px;">
                                {{ $data['single_room'] ?? 0 }}
                                <span style="color:red;">( {{ $data['single_room_sub'] ?? '2, 3' }} )</span>
                            </div>

                            <div class="mt-2">
                                <a href="{{ url('/admin/room-manage') }}">Room List <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase">Super Deluxe Room</h6>

                            <div style="font-size:18px;">
                                {{ $data['super_deluxe_room'] ?? 0 }}
                                <span style="color:red;">( {{ $data['super_deluxe_room_sub'] ?? '2, 3' }} )</span>
                            </div>

                            <div class="mt-2">
                                <a href="{{ url('/admin/room-manage') }}">Room List <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase">Double Room</h6>

                            <div style="font-size:18px;">
                                {{ $data['double_room'] ?? 0 }}
                                <span style="color:red;">( {{ $data['double_room_sub'] ?? '2, 3' }} )</span>
                            </div>

                            <div class="mt-2">
                                <a href="{{ url('/admin/room-manage') }}">Room List <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase">Alpha Room</h6>

                            <div style="font-size:18px;">
                                {{ $data['alpha_room'] ?? 0 }}
                                <span style="color:red;">( {{ $data['alpha_room_sub'] ?? '2, 3' }} )</span>
                            </div>

                            <div class="mt-2">
                                <a href="{{ url('/admin/room-manage') }}">Room List <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Row 2: 2 room cards + 2 delete cards --}}
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase">Royal Suite</h6>

                            <div style="font-size:18px;">
                                {{ $data['royal_suite'] ?? 0 }}
                                <span style="color:red;">( {{ $data['royal_suite_sub'] ?? '2, 3' }} )</span>
                            </div>

                            <div class="mt-2">
                                <a href="{{ url('/admin/room-manage') }}">Room List <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase">King Appt</h6>

                            <div style="font-size:18px;">
                                {{ $data['king_appt'] ?? 0 }}
                                <span style="color:red;">( {{ $data['king_appt_sub'] ?? '2, 3' }} )</span>
                            </div>

                            <div class="mt-2">
                                <a href="{{ url('/admin/room-manage') }}">Room List <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Delete Invoice --}}
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="background:#f8d7da;">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase" style="color:#dc3545;">Delete Invoice</h6>

                            <div class="mt-2">
                                <a href="{{ url('/admin/invoice/delete') }}" style="color:#0d6efd;">
                                    Click Here <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>

                            <div class="mt-2 text-muted">
                                Total: {{ $data['total_invoice'] ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Delete Accounts --}}
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="background:#f8d7da;">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase" style="color:#dc3545;">Delete Accounts</h6>

                            <div class="mt-2">
                                <a href="{{ url('/admin/accounts/delete') }}" style="color:#0d6efd;">
                                    Click Here <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>

                            <div class="mt-2 text-muted">
                                Total: {{ $data['total_accounts'] ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Row 3: Delete Guests --}}
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card" style="background:#f8d7da;">
                        <div class="card-body">
                            <h6 class="card-title mb-2 text-uppercase" style="color:#dc3545;">Delete Guests</h6>

                            <div class="mt-2">
                                <a href="{{ url('/admin/guests/delete') }}" style="color:#0d6efd;">
                                    Click Here <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>

                            <div class="mt-2 text-muted">
                                Total: {{ $data['total_guests'] ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>

            </div> {{-- row --}}

        </div>
    </div>
</div>
@endsection
