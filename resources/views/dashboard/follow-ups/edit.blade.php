@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Edit Follow Up</h1>
        <p class="text-sm text-slate-500">Update the scheduled follow-up for your deal.</p>
    </div>

    <form action="{{ route('dashboard.follow-ups.update', $followUp) }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        @csrf
        @method('PUT')

        @include('dashboard.forms.follow-up')

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Update follow-up</button>
            <a href="{{ route('dashboard.follow-ups.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Cancel</a>
        </div>
    </form>
@endsection
