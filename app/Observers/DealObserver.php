<?php

namespace App\Observers;

use App\Models\Deal;
use App\Services\DealService;

class DealObserver
{
    public function updated(Deal $deal): void
    {
        if ($deal->wasChanged('stage_id')) {
            $this->handleStageChange($deal);
        }
    }

    protected function handleStageChange(Deal $deal): void
    {
        $deal = $deal->fresh(['stage']);

        if (! $deal->stage || $deal->stage->stage_name !== 'Closed') {
            return;
        }

        app(DealService::class)->finalizeDeal($deal);
    }
}
