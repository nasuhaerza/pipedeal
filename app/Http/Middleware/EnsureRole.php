<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:super_admin') or 'role:company_admin,business_development'
     */
    public function handle(Request $request, Closure $next, string $roles = null): Response
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        if (empty($roles)) {
            return $next($request);
        }

        $allowed = collect(explode(',', $roles))->map(fn($r) => trim($r))->filter()->values()->all();

        // support helper methods on User model
        foreach ($allowed as $role) {
            $method = 'is' . str_replace(' ', '', ucwords(str_replace('_', ' ', $role)));
            if (method_exists($user, $method) && $user->{$method}()) {
                return $next($request);
            }
        }

        abort(403);
    }
}
