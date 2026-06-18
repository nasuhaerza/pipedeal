@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Clients</h1>
            <p class="text-sm text-slate-500">Kelola daftar klien untuk company Anda.</p>
        </div>

        <a href="{{ route('dashboard.clients.create') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">New Client</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Phone</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Deals</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($clients as $client)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $client->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $client->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $client->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $client->deals_count }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('dashboard.clients.show', $client) }}" class="text-slate-600 hover:text-slate-900">View</a>
                            <a href="{{ route('dashboard.clients.edit', $client) }}" class="ml-4 text-slate-900 hover:text-slate-600">Edit</a>
                            <form action="{{ route('dashboard.clients.destroy', $client) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-rose-600 hover:text-rose-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No clients yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
