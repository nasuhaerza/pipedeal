<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Deal;
use App\Models\Document;
use App\Models\FollowUp;
use Illuminate\Contracts\Auth\Authenticatable;

class ActivityLoggerService
{
    public function record(int $dealId, string $activityType, string $description, ?Authenticatable $user = null, ?int $companyId = null): Activity
    {
        return Activity::create([
            'company_id' => $companyId ?? $user?->company_id,
            'deal_id' => $dealId,
            'activity_type' => $activityType,
            'description' => $description,
            'created_by' => $user?->id,
        ]);
    }

    public function logDealCreated(Deal $deal, ?Authenticatable $user = null): Activity
    {
        return $this->record($deal->id, 'deal_created', "Deal {$deal->title} created", $user ?? auth()->user(), $deal->company_id);
    }

    public function logDealUpdated(Deal $deal, ?Authenticatable $user = null): Activity
    {
        return $this->record($deal->id, 'deal_updated', "Deal {$deal->title} updated", $user ?? auth()->user(), $deal->company_id);
    }

    public function logDealStageChanged(Deal $deal, ?Authenticatable $user = null): Activity
    {
        $stageName = $deal->fresh('stage')->stage?->stage_name ?? 'updated';

        return $this->record($deal->id, 'stage_changed', "Deal stage changed to {$stageName}", $user ?? auth()->user(), $deal->company_id);
    }

    public function logFollowUpCreated(FollowUp $followUp, ?Authenticatable $user = null): Activity
    {
        return $this->record($followUp->deal_id, 'followup_created', "Follow-up scheduled for deal {$followUp->deal->title}", $user ?? auth()->user(), $followUp->company_id ?? $followUp->deal->company_id);
    }

    public function logDocumentUploaded(Document $document, ?Authenticatable $user = null): Activity
    {
        return $this->record($document->deal_id, 'document_uploaded', "Document {$document->file_name} uploaded for deal {$document->deal->title}", $user ?? auth()->user(), $document->company_id ?? $document->deal->company_id);
    }
}
