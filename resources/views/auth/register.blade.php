@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Register Company</h2>
            <p class="small text-muted">Create a company and an administrator account</p>
        </div>
        <div class="text-end small">
            <a href="{{ route('login') }}">Already have account? Login</a>
        </div>
    </div>

    <div class="mb-4">
        <div class="progress" style="height:8px;">
            <div class="progress-bar" role="progressbar" style="width:50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between mt-2 small text-muted">
            <div>Step 1 — Company Information</div>
            <div>Step 2 — Administrator Account</div>
        </div>
    </div>

    <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Company Information</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input name="company_name" value="{{ old('company_name') }}" required class="form-control" />
                        @error('company_name')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Email</label>
                        <input name="email" type="email" value="{{ old('email') }}" required class="form-control" />
                        @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input name="phone" value="{{ old('phone') }}" class="form-control" />
                        @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input name="address" value="{{ old('address') }}" class="form-control" />
                        @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Administrator Account</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input name="name" value="{{ old('name') }}" required class="form-control" />
                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input name="user_email" type="email" value="{{ old('user_email') }}" required class="form-control" />
                        @error('user_email')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" required class="form-control" />
                        @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input name="password_confirmation" type="password" required class="form-control" />
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Register Company</button>
        </div>
    </form>
</div>
@endsection
