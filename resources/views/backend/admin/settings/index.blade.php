@extends('backend.admin.includes.admin_layout')

@section('content')
    <div class="page-content">

        ```
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <div>
                <h5 class="fw-bold mb-0">System Settings</h5>
                <small class="text-muted">Manage your school system configuration</small>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form action="{{ route('admin.settings.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- School Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">School Name</label>
                            <input type="text" name="school_name" class="form-control" placeholder="Enter school name">
                        </div>

                        {{-- School Email --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">School Email</label>
                            <input type="email" name="school_email" class="form-control" placeholder="Enter email">
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter address">
                        </div>

                        {{-- Logo Upload --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">School Logo</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                        {{-- Currency --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Currency</label>
                            <select class="form-control" name="currency">
                                <option value="BDT">BDT</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>

                    </div>

                    {{-- Save Button --}}
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Save Settings
                        </button>
                    </div>

                </form>

            </div>
        </div>
        ```

    </div>
@endsection
