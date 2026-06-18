<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PipeDeal') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="min-h-screen bg-slate-50 text-slate-900">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur-sm">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div class="text-lg font-semibold">PipeDeal</div>
                <nav class="flex items-center gap-3 text-sm text-slate-700">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="rounded-md px-3 py-2 hover:bg-slate-100">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-3 py-2 hover:bg-slate-100">Login</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
