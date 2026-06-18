@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Create Commission Share</h1>
        <p class="text-sm text-slate-500">Tambahkan pembagian komisi untuk deal tertentu.</p>
    </div>

    <form action="{{ route('dashboard.commission-shares.store') }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        @csrf

        <div>
            <label for="deal_id" class="block text-sm font-medium text-slate-700">Deal</label>
            <select id="deal_id" name="deal_id" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">
                <option value="">Select deal</option>
                @foreach ($deals as $deal)
                    <option value="{{ $deal->id }}" {{ old('deal_id') == $deal->id ? 'selected' : '' }}>{{ $deal->title }} - {{ $deal->client->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="recipient_name" class="block text-sm font-medium text-slate-700">Recipient Name</label>
            <input id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
        </div>

        <div>
            <label for="commission_percent" class="block text-sm font-medium text-slate-700">Commission Percent</label>
            <input id="commission_percent" name="commission_percent" type="number" min="0" max="100" step="0.01" value="{{ old('commission_percent') }}" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Save share</button>
            <a href="{{ route('dashboard.commission-shares.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Cancel</a>
        </div>
    </form>
@endsection
