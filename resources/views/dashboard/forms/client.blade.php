<div class="space-y-6">
    <div>
        <label for="client_name" class="block text-sm font-medium text-slate-700">Client Name</label>
        <input id="client_name" name="client_name" value="{{ old('client_name', $client->client_name ?? '') }}" required class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="industry" class="block text-sm font-medium text-slate-700">Industry</label>
        <input id="industry" name="industry" value="{{ old('industry', $client->industry ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="contact_person" class="block text-sm font-medium text-slate-700">Contact Person</label>
        <input id="contact_person" name="contact_person" value="{{ old('contact_person', $client->contact_person ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $client->email ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
        <input id="phone" name="phone" value="{{ old('phone', $client->phone ?? '') }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
    </div>

    <div>
        <label for="address" class="block text-sm font-medium text-slate-700">Address</label>
        <textarea id="address" name="address" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100">{{ old('address', $client->address ?? '') }}</textarea>
    </div>
</div>
