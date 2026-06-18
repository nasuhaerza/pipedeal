@extends('layouts.app')

@section('content')
    @include('dashboard.nav')

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Documents</h1>
            <p class="text-sm text-slate-500">Manage documents attached to your deals.</p>
        </div>
        <a href="{{ route('dashboard.documents.create') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Add document</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-900">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Deal</th>
                    <th class="px-6 py-4">Client</th>
                    <th class="px-6 py-4">File Path</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($documents as $document)
                    <tr>
                        <td class="px-6 py-4">{{ $document->name }}</td>
                        <td class="px-6 py-4">{{ $document->deal->title }}</td>
                        <td class="px-6 py-4">{{ $document->deal->client->name }}</td>
                        <td class="px-6 py-4">{{ $document->file_path }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('dashboard.documents.show', $document) }}" class="text-slate-600 hover:text-slate-900">View</a>
                            <a href="{{ route('dashboard.documents.edit', $document) }}" class="text-slate-600 hover:text-slate-900">Edit</a>
                            <form action="{{ route('dashboard.documents.destroy', $document) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">No documents uploaded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
