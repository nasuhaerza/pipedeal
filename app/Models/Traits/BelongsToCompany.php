<?php

namespace App\Models\Traits;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

trait BelongsToCompany
{
    public static function bootBelongsToCompany(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function (Model $model): void {
            if (! $model->company_id && $user = auth()->user()) {
                $model->company_id = $user->company_id;
            }
        });
    }
}
