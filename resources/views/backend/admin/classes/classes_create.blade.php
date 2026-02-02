@extends('backend.admin.includes.admin_layout')

@section('content')
<div class="page-content">

    {{-- Top Right Buttons --}}
    <div class="d-flex justify-content-end align-items-center gap-2 mb-3 mt-4">
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary btn-sm px-3">
            ← Back
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger py-2 mb-2">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h4 class="text-center fw-bold mb-4">Class Add</h4>

            <form action="{{ route('admin.classes.store') }}" method="POST">
                @csrf

                <div class="row g-4">

                    {{-- Class Name --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Class Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="class_name"
                               value="{{ old('class_name') }}"
                               class="form-control"
                               placeholder="Enter Class Name"
                               required>
                    </div>

                    {{-- Section --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Section</label>
                        <input type="text"
                               name="section"
                               value="{{ old('section') }}"
                               class="form-control"
                               placeholder="Enter Section (optional)">
                    </div>

                    {{-- Class Code --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Class Code <span class="text-danger">*</span></label>
                        <input type="text"
                               name="class_code"
                               value="{{ old('class_code') }}"
                               class="form-control"
                               placeholder="Enter Class Code"
                               required>
                    </div>

                    {{-- Academic Year --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Academic Year</label>
                        <input type="text"
                               name="academic_year"
                               value="{{ old('academic_year') }}"
                               class="form-control"
                               placeholder="e.g. 2025">
                    </div>

                    {{-- Description --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Enter Description (optional)">{{ old('description') }}</textarea>
                    </div>

                    {{-- Status (like Yes/No) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block">Status</label>

                        @php
                            $statusOld = old('status', 1); // default Active
                        @endphp

                        <div class="d-flex align-items-center gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusActive" value="1"
                                       {{ (string)$statusOld === "1" ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusActive">Active</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusInactive" value="0"
                                       {{ (string)$statusOld === "0" ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusInactive">Inactive</label>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-light px-4">Reset</button>
                    <button type="submit" class="btn btn-success px-4">Save</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('css')
<style>
    /* Similar clean input vibe like screenshot */
    .form-control {
        height: 38px;
        border-radius: 6px;
    }
    textarea.form-control {
        height: auto;
    }
    .form-label {
        margin-bottom: 6px;
        color: #1f2937;
    }
</style>
@endpush
