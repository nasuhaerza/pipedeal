<?php

namespace App\Observers;

use App\Models\CommissionShare;

class CommissionShareObserver
{
    public function creating(CommissionShare $commissionShare): void
    {
        $this->calculateCommissionAmount($commissionShare);
    }

    public function updating(CommissionShare $commissionShare): void
    {
        $this->calculateCommissionAmount($commissionShare);
    }

    protected function calculateCommissionAmount(CommissionShare $commissionShare): void
    {
        if (! $commissionShare->deal || $commissionShare->deal->stage->stage_name !== 'Closed') {
            return;
        }

        $commissionShare->commission_amount = round(
            $commissionShare->deal->deal_value * ($commissionShare->commission_percent / 100),
            2
        );
    }
}
