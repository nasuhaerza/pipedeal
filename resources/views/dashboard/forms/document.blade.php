<div class="space-y-6">
    <div>
        <label for="deal_id" class="block text-sm font-medium text-slate-700">Deal</label>
        <select id="deal_id" name="deal_id" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">
            <option value="">Select a deal</option>
            @foreach($deals as $deal)
                <option value="{{ $deal->id }}" {{ old('deal_id', isset($document) ? $document->deal_id : ($dealId ?? '')) == $deal->id ? 'selected' : '' }}>{{ $deal->title }} ({{ $deal->client->name }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="file_name" class="block text-sm font-medium text-slate-700">Document Name</label>
        <input id="file_name" name="file_name" value="{{ old('file_name', isset($document) ? $document->file_name : '') }}" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="file" class="block text-sm font-medium text-slate-700">Upload File</label>
        <input id="file" name="file" type="file" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
        @isset($document)
            <p class="mt-2 text-sm text-slate-500">Current file: <a class="text-slate-900 underline" href="{{ Storage::disk('public')->url($document->file_path) }}" target="_blank">{{ $document->file_name }}</a></p>
        @endisset
    </div>

    <div>
        <label for="notes" class="block text-sm font-medium text-slate-700">Notes</label>
        <textarea id="notes" name="notes" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">{{ old('notes', isset($document) ? $document->notes : '') }}</textarea>
    </div>
</div>
