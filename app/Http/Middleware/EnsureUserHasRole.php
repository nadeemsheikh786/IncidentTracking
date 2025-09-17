<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check() || auth()->user()->role?->value !== $role) {
            throw new AccessDeniedHttpException('Unauthorized.');
        }
        return $next($request);
    }
}
