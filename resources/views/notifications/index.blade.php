@extends('backend.admin.includes.admin_layout')

@section('content')

    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div>
                <h5 class="fw-bold mb-0">Notifications</h5>
                <small class="text-muted">System notifications</small>
            </div>
        </div>

        @if ($notifications->count() == 0)
            <div class="alert alert-info">
                No notifications found.
            </div>
        @else
            @foreach ($notifications as $notification)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">

                        <h6 class="mb-1">
                            {{ $notification->data['title'] ?? 'Notification' }}
                        </h6>

                        <p class="mb-1">
                            {{ $notification->data['message'] ?? '' }}
                        </p>

                        <small class="text-muted">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>

                    </div>
                </div>
            @endforeach
        @endif

    </div>

@endsection
