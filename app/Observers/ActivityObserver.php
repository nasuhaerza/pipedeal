<?php

namespace App\Observers;

use App\Models\Deal;
use App\Models\Document;
use App\Models\FollowUp;
use App\Services\ActivityLoggerService;
use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    public function created(Model $model): void
    {
        if ($model instanceof Deal) {
            app(ActivityLoggerService::class)->logDealCreated($model);
        }

        if ($model instanceof FollowUp) {
            app(ActivityLoggerService::class)->logFollowUpCreated($model);
        }

        if ($model instanceof Document) {
            app(ActivityLoggerService::class)->logDocumentUploaded($model);
        }
    }

    public function updated(Model $model): void
    {
        if (! $model instanceof Deal) {
            return;
        }

        app(ActivityLoggerService::class)->logDealUpdated($model);

        if ($model->wasChanged('stage_id')) {
            app(ActivityLoggerService::class)->logDealStageChanged($model);
        }
    }
}
