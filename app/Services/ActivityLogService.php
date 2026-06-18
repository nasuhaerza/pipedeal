<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    public function record(Model $model, string $action, string $description, ?Authenticatable $user = null): ActivityLog
    {
        return ActivityLog::create([
            'company_id' => $user?->company_id ?? $model->company_id,
            'user_id' => $user?->id,
            'loggable_type' => get_class($model),
            'loggable_id' => $model->getKey(),
            'action' => $action,
            'description' => $description,
        ]);
    }
}
