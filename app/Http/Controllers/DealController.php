<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealRequest;
use App\Models\Deal;
use App\Services\ActivityLogService;
use App\Services\DealService;
use Illuminate\Http\JsonResponse;

class DealController extends Controller
{
    public function index(): JsonResponse
    {
        $deals = Deal::with(['client', 'stage', 'commissionShares', 'followUps', 'documents'])->get();

        return response()->json($deals);
    }

    public function store(DealRequest $request, DealService $dealService, ActivityLogService $activityLogService): JsonResponse
    {
        $deal = Deal::create($request->validated());
        $dealService->finalizeDeal($deal);
        $activityLogService->record($deal, 'created', "Deal {$deal->title} created", auth()->user());

        return response()->json($deal->load(['client', 'stage']), 201);
    }

    public function show(Deal $deal): JsonResponse
    {
        $this->authorize('view', $deal);

        return response()->json($deal->load(['client', 'stage', 'commissionShares', 'followUps', 'documents']));
    }

    public function update(DealRequest $request, Deal $deal, DealService $dealService, ActivityLogService $activityLogService): JsonResponse
    {
        $this->authorize('update', $deal);

        $deal->update($request->validated());
        $dealService->finalizeDeal($deal);
        $activityLogService->record($deal, 'updated', "Deal {$deal->title} updated", auth()->user());

        return response()->json($deal->load(['client', 'stage']));
    }

    public function destroy(Deal $deal): JsonResponse
    {
        $this->authorize('delete', $deal);

        $deal->delete();

        return response()->json(['message' => 'Deal removed.']);
    }
}
