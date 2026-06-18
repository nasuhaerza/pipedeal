<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnsureCompanyAdmin
{
    public function handle(Request $request, Closure $next): RedirectResponse|\Illuminate\Http\Response
    {
        $user = $request->user();

        if (! $user || $user->role !== UserRole::COMPANY_ADMIN) {
            abort(403);
        }

        return $next($request);
    }
}
