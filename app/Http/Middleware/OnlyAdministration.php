<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OnlyAdministration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::User()->login == 'admin' || Auth::User()->login == 'admin_reserved') {
                return $next($request);
            }
            return false;
        }
        return redirect()->route('admin/main');
    }
}
