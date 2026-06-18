@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Commission Shares</h1>
            <p class="text-sm text-slate-500">Kelola pembagian komisi untuk setiap deal.</p>
        </div>

        <a href="{{ route('dashboard.commission-shares.create') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">New Share</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Deal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Recipient</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Commission %</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Amount</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($shares as $share)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $share->deal->title }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $share->recipient_name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ number_format($share->commission_percent, 2) }}%</td>
                        <td class="px-6 py-4 text-sm text-slate-600">Rp {{ number_format($share->commission_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('dashboard.commission-shares.edit', $share) }}" class="text-slate-900 hover:text-slate-600">Edit</a>
                            <form action="{{ route('dashboard.commission-shares.destroy', $share) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-rose-600 hover:text-rose-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No commission shares yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
