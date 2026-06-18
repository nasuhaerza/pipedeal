<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\CommissionShare;
use Illuminate\Database\Eloquent\Collection;

class DealService
{
    public function finalizeDeal(Deal $deal): void
    {
        if (! $deal->stage || $deal->stage->stage_name !== 'Closed') {
            return;
        }

        $shares = $deal->commissionShares()->get();

        foreach ($shares as $share) {
            $share->commission_amount = $this->calculateCommissionAmount($deal->deal_value, $share->commission_percent);
            $share->save();
        }
    }

    public function calculateCommissionAmount(float $amount, float $percentage): float
    {
        return round($amount * ($percentage / 100), 2);
    }
}
