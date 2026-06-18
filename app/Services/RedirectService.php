<?php

namespace App\Services;

use App\Models\User;

class RedirectService
{
    public function pathFor(User $user): string
    {
        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return '/super-admin/dashboard';
        }

        if (method_exists($user, 'isCompanyAdmin') && $user->isCompanyAdmin()) {
            return '/company/dashboard';
        }

        if (method_exists($user, 'isBusinessDevelopment') && $user->isBusinessDevelopment()) {
            return '/bd/dashboard';
        }

        return '/dashboard';
    }
}
