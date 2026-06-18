<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Services\ActivityLogService;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function index(): JsonResponse
    {
        $clients = Client::with('deals')->get();

        return response()->json($clients);
    }

    public function store(ClientRequest $request, ActivityLogService $activityLogService): JsonResponse
    {
        $client = Client::create($request->validated());
        $activityLogService->record($client, 'created', "Client {$client->name} created", auth()->user());

        return response()->json($client, 201);
    }

    public function show(Client $client): JsonResponse
    {
        $this->authorize('view', $client);

        return response()->json($client);
    }

    public function update(ClientRequest $request, Client $client, ActivityLogService $activityLogService): JsonResponse
    {
        $this->authorize('update', $client);

        $client->update($request->validated());
        $activityLogService->record($client, 'updated', "Client {$client->name} updated", auth()->user());

        return response()->json($client);
    }

    public function destroy(Client $client): JsonResponse
    {
        $this->authorize('delete', $client);

        $client->delete();

        return response()->json(['message' => 'Client removed.']);
    }
}
