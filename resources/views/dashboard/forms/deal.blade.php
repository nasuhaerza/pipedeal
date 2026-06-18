<div class="space-y-6">
    <div>
        <label for="deal_name" class="block text-sm font-medium text-slate-700">Deal Name</label>
        <input id="deal_name" name="deal_name" value="{{ old('deal_name', $deal->deal_name ?? '') }}" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="client_id" class="block text-sm font-medium text-slate-700">Client</label>
        <select id="client_id" name="client_id" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">
            <option value="">Select a client</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id', isset($deal) ? $deal->client_id : ($clientId ?? '')) == $client->id ? 'selected' : '' }}>{{ $client->client_name ?? $client->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="stage_id" class="block text-sm font-medium text-slate-700">Pipeline Stage</label>
        <select id="stage_id" name="stage_id" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">
            <option value="">Select stage</option>
            @foreach($stages as $stage)
                <option value="{{ $stage->id }}" {{ old('stage_id', isset($deal) ? $deal->stage_id : '') == $stage->id ? 'selected' : '' }}>{{ $stage->stage_name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="deal_value" class="block text-sm font-medium text-slate-700">Deal Value</label>
        <input id="deal_value" name="deal_value" type="number" step="0.01" value="{{ old('deal_value', isset($deal) ? $deal->deal_value : '') }}" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="expected_close_date" class="block text-sm font-medium text-slate-700">Expected Close Date</label>
        <input id="expected_close_date" name="expected_close_date" type="date" value="{{ old('expected_close_date', isset($deal) && $deal->expected_close_date ? $deal->expected_close_date->format('Y-m-d') : '') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="notes" class="block text-sm font-medium text-slate-700">Notes</label>
        <textarea id="notes" name="notes" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">{{ old('notes', isset($deal) ? $deal->notes : '') }}</textarea>
    </div>
</div>
