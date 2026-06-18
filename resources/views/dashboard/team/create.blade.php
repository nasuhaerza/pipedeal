@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
    <div class="mb-6">
        <h1 class="text-3xl font-semibold text-slate-900">Add Business Development</h1>
        <p class="mt-2 text-sm text-slate-500">Create a team member to help manage deals in your company.</p>
    </div>

    <form action="{{ route('dashboard.team.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
            <input id="name" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" />
            @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" />
            @error('email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" required class="mt-2 w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" />
                @error('password')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-2 w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" />
            </div>
        </div>

        <button type="submit" class="w-full rounded-3xl bg-[#2563EB] px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-600">Add team member</button>
    </form>
</div>
@endsection
