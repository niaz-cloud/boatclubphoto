@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <h5 class="mb-0 fw-semibold">Edit Auditor</h5>

        <a href="{{ route('admin.auditors.index') }}"
           class="btn btn-secondary btn-sm px-3">
            ← Back to List
        </a>
    </div>

    {{-- Card --}}
    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.auditors.update', $auditor->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label class="form-label">Auditor Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $auditor->name) }}"
                               required>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $auditor->email) }}">
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone', $auditor->phone) }}">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="1" {{ $auditor->status == 1 ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="0" {{ $auditor->status == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    {{-- Photo --}}
                    <div class="col-md-6">
                        <label class="form-label">Photo</label>
                        <input type="file"
                               name="photo"
                               class="form-control"
                               accept="image/*">
                    </div>

                    {{-- Existing Photo --}}
                    <div class="col-md-6">
                        <label class="form-label d-block">Current Photo</label>
                        @if($auditor->photo)
                            <img src="{{ asset('uploads/auditors/'.$auditor->photo) }}"
                                 class="rounded"
                                 width="80"
                                 height="80">
                        @else
                            <span class="text-muted">No photo uploaded</span>
                        @endif
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Update Auditor
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
