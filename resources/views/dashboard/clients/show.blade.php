@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Client Detail</h1>
            <p class="text-sm text-slate-500">Lihat ringkasan klien dan semua deal yang terkait.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('dashboard.clients.edit', $client) }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Edit client</a>
            <a href="{{ route('dashboard.deals.create') }}?client_id={{ $client->id }}" class="rounded-full bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-600">New deal</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[2fr_1fr]">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="space-y-5">
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Name</h2>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $client->name }}</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Email</h3>
                        <p class="mt-3 text-slate-900">{{ $client->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Phone</h3>
                        <p class="mt-3 text-slate-900">{{ $client->phone ?? 'N/A' }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Address</h3>
                    <p class="mt-3 text-slate-900 whitespace-pre-line">{{ $client->address ?? 'No address provided.' }}</p>
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Stats</h2>
            <div class="mt-4 space-y-4">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Total Deals</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $client->deals->count() }}</p>
                </div>
            </div>
        </section>
    </div>

    <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">Deals</h2>
            <a href="{{ route('dashboard.deals.create') }}?client_id={{ $client->id }}" class="text-sm font-semibold text-slate-900 hover:text-slate-700">Add new deal</a>
        </div>

        @if($client->deals->isEmpty())
            <p class="text-sm text-slate-500">No deals for this client yet.</p>
        @else
            <div class="space-y-4">
                @foreach($client->deals as $deal)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $deal->deal_name }}</p>
                                <p class="text-sm text-slate-600">Stage: {{ $deal->stage->stage_name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-slate-500">Rp {{ number_format($deal->deal_value, 0, ',', '.') }}</p>
                                <a href="{{ route('dashboard.deals.show', $deal) }}" class="text-sm font-semibold text-slate-900 hover:text-slate-700">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
