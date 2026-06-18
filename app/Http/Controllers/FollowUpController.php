<?php

namespace App\Http\Controllers;

use App\Http\Requests\FollowUpRequest;
use App\Models\FollowUp;
use App\Services\ActivityLogService;
use Illuminate\Http\JsonResponse;

class FollowUpController extends Controller
{
    public function index(): JsonResponse
    {
        $followUps = FollowUp::with('deal')->get();

        return response()->json($followUps);
    }

    public function store(FollowUpRequest $request, ActivityLogService $activityLogService): JsonResponse
    {
        $followUp = FollowUp::create($request->validated());
        $activityLogService->record($followUp, 'created', "Follow-up scheduled for deal {$followUp->deal_id}", auth()->user());

        return response()->json($followUp, 201);
    }

    public function show(FollowUp $followUp): JsonResponse
    {
        $this->authorize('view', $followUp);

        return response()->json($followUp);
    }

    public function update(FollowUpRequest $request, FollowUp $followUp, ActivityLogService $activityLogService): JsonResponse
    {
        $this->authorize('update', $followUp);

        $followUp->update($request->validated());
        $activityLogService->record($followUp, 'updated', "Follow-up {$followUp->id} updated", auth()->user());

        return response()->json($followUp);
    }

    public function destroy(FollowUp $followUp): JsonResponse
    {
        $this->authorize('delete', $followUp);

        $followUp->delete();

        return response()->json(['message' => 'Follow-up removed.']);
    }
}
