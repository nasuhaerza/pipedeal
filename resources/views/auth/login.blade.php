<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PipeDeal — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #F8FAFC; }
        .glass {
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 8px 24px rgba(2,6,23,0.08);
        }
        .left-panel { background: linear-gradient(180deg, #2563EB 0%, #1E293B 100%); color: #fff; }
        .brand-logo { font-weight:700; letter-spacing:0.2px; }
        @media (max-width: 767px) {
            .split { flex-direction: column; }
            .left-panel { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
<div class="container vh-100 d-flex align-items-center">
    <div class="row w-100 split d-flex">
        <div class="col-md-6 left-panel d-flex flex-column justify-content-center p-5">
            <div class="mb-4">
                <div class="brand-logo h2">PipeDeal</div>
                <div class="small">&mdash; Sales pipeline & commissions</div>
            </div>
            <h1 class="display-6">Manage Your Deal Pipeline Efficiently</h1>
            <p class="lead text-muted">Track deals, commissions, agreements and partner collaboration in one platform.</p>
        </div>

        <div class="col-md-6 d-flex align-items-center justify-content-center p-4">
            <div class="w-100" style="max-width:420px;">
                <div class="glass p-4">
                    <h4 class="mb-3">Sign in to your account</h4>

                    @if($errors->any())
                        <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <div class="d-grid mb-3">
                            <button class="btn btn-primary">Login</button>
                        </div>

                        <div class="d-flex justify-content-between small">
                            <a href="{{ route('register') }}">Register Company</a>
                            <a href="#">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
    <h1 class="mb-4 text-2xl font-semibold text-slate-900">Login to PipeDeal</h1>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-2 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input id="password" name="password" type="password" required class="mt-1 w-full rounded-lg border border-slate-300 bg-slate-50 px-4 py-2 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
        </div>

        <button type="submit" class="w-full rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Login</button>
    </form>
</div>
@endsection
