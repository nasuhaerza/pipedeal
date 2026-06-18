<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissionShareRequest;
use App\Models\CommissionShare;
use App\Models\Deal;
use App\Services\ActivityLogService;
use Illuminate\Http\JsonResponse;

class CommissionShareController extends Controller
{
    public function index(): JsonResponse
    {
        $shares = CommissionShare::with('deal')->get();

        return response()->json($shares);
    }

    public function store(CommissionShareRequest $request, ActivityLogService $activityLogService): JsonResponse
    {
        $share = CommissionShare::create($request->validated());
        $activityLogService->record($share, 'created', "Commission share for deal {$share->deal_id} created", auth()->user());

        $this->ensureCommissionIsComplete($share->deal);

        return response()->json($share, 201);
    }

    public function show(CommissionShare $commissionShare): JsonResponse
    {
        $this->authorize('view', $commissionShare);

        return response()->json($commissionShare);
    }

    public function update(CommissionShareRequest $request, CommissionShare $commissionShare, ActivityLogService $activityLogService): JsonResponse
    {
        $this->authorize('update', $commissionShare);

        $commissionShare->update($request->validated());
        $activityLogService->record($commissionShare, 'updated', "Commission share {$commissionShare->id} updated", auth()->user());

        $this->ensureCommissionIsComplete($commissionShare->deal);

        return response()->json($commissionShare);
    }

    public function destroy(CommissionShare $commissionShare): JsonResponse
    {
        $this->authorize('delete', $commissionShare);

        $commissionShare->delete();

        return response()->json(['message' => 'Commission share removed.']);
    }

    protected function ensureCommissionIsComplete(Deal $deal): void
    {
        if ($deal->stage_id && $deal->stage->stage_name === 'Closed') {
            $total = $deal->commissionShares()->sum('commission_percent');
            if (abs($total - 100.0) > 0.01) {
                abort(422, 'Total commission shares must be 100% for a closed deal.');
            }
        }
    }
}
