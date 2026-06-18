<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientWebController extends Controller
{
    public function index(): View
    {
        $clients = Client::withCount('deals')->get();

        return view('dashboard.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('dashboard.clients.create');
    }

    public function store(ClientRequest $request, ActivityLogService $activityLogService): RedirectResponse
    {
        $client = Client::create($request->validated());
        $activityLogService->record($client, 'created', "Client {$client->name} created", auth()->user());

        return redirect()->route('dashboard.clients.index')->with('status', 'Client saved.');
    }

    public function show(Client $client): View
    {
        $this->authorize('view', $client);

        $client->load(['deals.stage']);

        return view('dashboard.clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        $this->authorize('view', $client);

        return view('dashboard.clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client, ActivityLogService $activityLogService): RedirectResponse
    {
        $this->authorize('update', $client);

        $client->update($request->validated());
        $activityLogService->record($client, 'updated', "Client {$client->name} updated", auth()->user());

        return redirect()->route('dashboard.clients.index')->with('status', 'Client updated.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->authorize('delete', $client);

        $client->delete();

        return redirect()->route('dashboard.clients.index')->with('status', 'Client removed.');
    }
}
