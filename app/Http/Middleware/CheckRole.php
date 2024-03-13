<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = auth()->user();
        // No need to check if the user has any role; it's assumed they have one.
        // Directly check if they have the required role or if they are an Admin.
        if (!$user->hasRole($role) && !$user->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
