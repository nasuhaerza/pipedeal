<div class="space-y-6">
    <div>
        <label for="deal_id" class="block text-sm font-medium text-slate-700">Deal</label>
        <select id="deal_id" name="deal_id" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">
            <option value="">Select a deal</option>
            @foreach($deals as $deal)
                <option value="{{ $deal->id }}" {{ old('deal_id', isset($followUp) ? $followUp->deal_id : ($dealId ?? '')) == $deal->id ? 'selected' : '' }}>{{ $deal->title }} ({{ $deal->client->name }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="scheduled_at" class="block text-sm font-medium text-slate-700">Scheduled At</label>
        <input id="scheduled_at" name="scheduled_at" type="datetime-local" value="{{ old('scheduled_at', isset($followUp) && $followUp->scheduled_at ? $followUp->scheduled_at->format('Y-m-d\TH:i') : '') }}" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="notes" class="block text-sm font-medium text-slate-700">Notes</label>
        <textarea id="notes" name="notes" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">{{ old('notes', isset($followUp) ? $followUp->notes : '') }}</textarea>
    </div>
</div>
