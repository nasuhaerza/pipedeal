@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Follow-up Detail</h1>
            <p class="text-sm text-slate-500">Lihat informasi lengkap untuk jadwal follow-up ini.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('dashboard.follow-ups.edit', $followUp) }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Edit follow-up</a>
            <a href="{{ route('dashboard.deals.show', $followUp->deal) }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 hover:border-slate-300">View deal</a>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Deal</h2>
                <p class="mt-3 text-lg font-semibold text-slate-900">{{ $followUp->deal->title }}</p>
                <p class="text-sm text-slate-600">Client: {{ $followUp->deal->client->name }}</p>
            </div>

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Scheduled At</h2>
                <p class="mt-3 text-lg text-slate-900">{{ optional($followUp->scheduled_at)->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 pt-6">
            <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Notes</h2>
            <p class="mt-3 text-slate-900 whitespace-pre-line">{{ $followUp->notes ?? 'No notes provided.' }}</p>
        </div>
    </div>
@endsection
