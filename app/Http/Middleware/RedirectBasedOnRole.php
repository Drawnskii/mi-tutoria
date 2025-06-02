<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * If the user is authenticated and is not already on their
     * role’s named route, redirect them to route($roleName).
     * Otherwise, allow the request to continue.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \Closure(\Illuminate\Http\Request): 
     *         (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // If not logged in, just keep going
        if (! Auth::check()) {
            return $next($request);
        }

        // Grab the authenticated user’s role name (must match a route name)
        $roleName = Auth::user()->role->name; 
        // e.g. "student", "tutor", "coordinator", etc.

        // Get current route name (null if route has no name)
        $currentRoute = $request->route() 
            ? $request->route()->getName() 
            : null;

        // If they’re already on their own dashboard (route name == roleName),
        // let them proceed:
        if ($currentRoute === $roleName) {
            return $next($request);
        }

        // Otherwise, send them to their role’s route:
        return redirect()->route($roleName);
    }
}
