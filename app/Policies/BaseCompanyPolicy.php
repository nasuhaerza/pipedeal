<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class BaseCompanyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, $model): bool
    {
        return $this->isAllowed($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, $model): bool
    {
        return $this->isAllowed($user, $model);
    }

    public function delete(User $user, $model): bool
    {
        return $this->isAllowed($user, $model);
    }

    protected function isAllowed(User $user, $model): bool
    {
        if ($user->role === UserRole::SUPER_ADMIN) {
            return true;
        }

        return isset($model->company_id) && $model->company_id === $user->company_id;
    }
}
