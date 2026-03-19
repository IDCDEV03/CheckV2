<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
         if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $activeRole = session('active_role', $user->role->value);

        if (!in_array($activeRole, $roles)) {
            abort(403, 'Access denied');
        }

        return $next($request);
      
    }
}
