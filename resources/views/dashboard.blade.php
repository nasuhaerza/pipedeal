@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="grid gap-6 md:grid-cols-3">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Clients</h2>
        <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $clients }}</p>
    </article>

    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Deals</h2>
        <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $deals }}</p>
    </article>

    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Closed Deals</h2>
        <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $closedDeals }}</p>
    </article>
</div>

<div class="mt-6 grid gap-6 md:grid-cols-3">
        <a href="{{ route('dashboard.commission-shares.index') }}" class="block rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:border-slate-300">
            <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Commission Shares</h2>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $commissionShares }}</p>
        </a>

        <a href="{{ route('dashboard.documents.index') }}" class="block rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:border-slate-300">
            <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Documents</h2>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $documents }}</p>
        </a>

        <a href="{{ route('dashboard.follow-ups.index') }}" class="block rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:border-slate-300">
            <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Follow Ups</h2>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $followUps }}</p>
        </a>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Upcoming Follow Ups</h2>
                    <p class="text-sm text-slate-500">Latest follow-up schedule items.</p>
                </div>
                <a href="{{ route('dashboard.follow-ups.index') }}" class="text-sm font-semibold text-slate-900 hover:text-slate-700">View all</a>
            </div>

            <div class="space-y-4">
                @forelse($latestFollowUps as $followUp)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="font-semibold text-slate-900">{{ $followUp->deal->title }}</p>
                        <p class="text-sm text-slate-600">{{ optional($followUp->scheduled_at)->format('d M Y H:i') }} · {{ $followUp->deal->client->name }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No follow-ups scheduled yet.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Recent Documents</h2>
                    <p class="text-sm text-slate-500">Most recently attached files.</p>
                </div>
                <a href="{{ route('dashboard.documents.index') }}" class="text-sm font-semibold text-slate-900 hover:text-slate-700">View all</a>
            </div>

            <div class="space-y-4">
                @forelse($latestDocuments as $document)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="font-semibold text-slate-900">{{ $document->name }}</p>
                        <p class="text-sm text-slate-600">{{ $document->deal->title }} · {{ $document->deal->client->name }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No documents attached yet.</p>
                @endforelse
            </div>
        </section>
@endsection
