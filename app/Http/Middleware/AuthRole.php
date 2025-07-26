<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    /**
     * @param  array|string  $roles
     */
    public function __construct(private array|string $roles = []) {}
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $user = Auth::user();

        if (!$user->hasAnyRole($roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'Access denied. Proper role required.');
        }
        return $next($request);
    }
}
