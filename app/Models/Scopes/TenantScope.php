<?php

namespace App\Models\Scopes;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        return;
        // $user = auth()->user();

        // if (! $user || $user->role === UserRole::SUPER_ADMIN) {
        //     return;
        // }

        // $builder->where($model->getTable() . '.company_id', $user->company_id);
    }

    public function extend(Builder $builder): void
    {
        $builder->macro('withoutTenantScope', function (Builder $builder) {
            return $builder->withoutGlobalScope(self::class);
        });
    }
}
