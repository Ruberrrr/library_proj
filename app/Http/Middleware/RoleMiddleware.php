<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        return $next($request);
    }
}