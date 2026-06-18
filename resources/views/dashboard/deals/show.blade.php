@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Deal Details</h1>
            <p class="text-sm text-slate-500">Lihat ringkasan, follow-up, dan dokumen terkait deal.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('dashboard.follow-ups.create', ['deal_id' => $deal->id]) }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Schedule follow-up</a>
            <a href="{{ route('dashboard.documents.create', ['deal_id' => $deal->id]) }}" class="rounded-full bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-600">Add document</a>
            <a href="{{ route('dashboard.deals.edit', $deal) }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 hover:border-slate-300">Edit deal</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[2fr_1fr]">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6 grid gap-4 sm:grid-cols-2">
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Deal Name</h2>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $deal->deal_name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Client</h2>
                    <p class="mt-3 text-lg text-slate-900">{{ $deal->client->name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Stage</h2>
                    <p class="mt-3 text-lg text-slate-900">{{ $deal->stage->stage_name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Deal Value</h2>
                    <p class="mt-3 text-lg text-slate-900">Rp {{ number_format($deal->deal_value, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="space-y-4 border-t border-slate-200 pt-6">
                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Expected Close Date</h2>
                    <p class="mt-3 text-slate-900">{{ optional($deal->expected_close_date)->format('d M Y') ?? 'Not closed yet' }}</p>
                </div>

                <div>
                    <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Notes</h2>
                    <p class="mt-3 text-slate-900 whitespace-pre-line">{{ $deal->notes ?? 'No notes available.' }}</p>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Commission Shares</h2>
                @if($deal->commissionShares->isEmpty())
                    <p class="mt-4 text-sm text-slate-500">No commission shares recorded.</p>
                @else
                    <div class="mt-4 space-y-3">
                        @foreach($deal->commissionShares as $share)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="font-semibold text-slate-900">{{ $share->user->name ?? 'Team member' }}</p>
                                <p class="text-sm text-slate-600">{{ $share->percentage }}% share</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Recent Follow Ups</h2>
                @if($deal->followUps->isEmpty())
                    <p class="mt-4 text-sm text-slate-500">No follow-ups scheduled yet.</p>
                @else
                    <div class="mt-4 space-y-3">
                        @foreach($deal->followUps as $followUp)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                <p class="font-semibold text-slate-900">{{ optional($followUp->scheduled_at)->format('d M Y H:i') }}</p>
                                <p class="text-sm text-slate-600">{{ Str::limit($followUp->notes, 80) }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>
        </section>
    </div>

    <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">Documents</h2>
            <a href="{{ route('dashboard.documents.create', ['deal_id' => $deal->id]) }}" class="text-sm font-semibold text-slate-900 hover:text-slate-700">Add document</a>
        </div>

        @if($deal->documents->isEmpty())
            <p class="text-sm text-slate-500">No documents attached to this deal yet.</p>
        @else
            <div class="space-y-3">
                @foreach($deal->documents as $document)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="font-semibold text-slate-900">{{ $document->name }}</p>
                        <p class="text-sm text-slate-600">{{ $document->file_path }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
