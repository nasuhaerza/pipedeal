<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\PipelineStage;
use Illuminate\Contracts\Auth\Authenticatable;

class PipelineService
{
    public function __construct(
        protected DealService $dealService,
        protected ActivityLogService $activityLogService
    ) {
    }

    public function moveDealToStage(Deal $deal, PipelineStage $stage, ?Authenticatable $user = null): Deal
    {
        $deal->stage()->associate($stage);
        $deal->save();

        $this->dealService->finalizeDeal($deal);

        $this->activityLogService->record(
            $deal,
            'stage_changed',
            "Deal {$deal->title} moved to {$stage->stage_name}",
            $user
        );

        return $deal->fresh('stage');
    }
}
