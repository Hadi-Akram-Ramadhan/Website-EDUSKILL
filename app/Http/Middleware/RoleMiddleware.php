<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Check if user role matches any allowed role
        if (! in_array($user->role, $roles)) {
            if ($user->role === 'super_admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'guru') {
                return redirect()->route('mentor.dashboard');
            }

            return redirect()->route('learn.index')->with('error', 'Akses dibatasi untuk peran Anda.');
        }

        return $next($request);
    }
}
