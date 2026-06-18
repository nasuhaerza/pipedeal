@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Edit Client</h1>
        <p class="text-sm text-slate-500">Perbarui data klien yang sudah ada.</p>
    </div>

    <form action="{{ route('dashboard.clients.update', $client) }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        @csrf
        @method('PUT')

        @include('dashboard.forms.client')

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Update client</button>
            <a href="{{ route('dashboard.clients.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Cancel</a>
        </div>
    </form>
@endsection
