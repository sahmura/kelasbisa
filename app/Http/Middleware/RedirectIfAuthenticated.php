<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if ($request->segment(1) == 'user') {
        //     $guard = 'user';
        // } else if ($request->segment(1) == 'admin') {
        //     $guard = 'admin';
        // }

        if (Auth::guard($guard)->check()) {
            return redirect('/' . Auth::user()->role);
        }

        return $next($request);
    }
}
