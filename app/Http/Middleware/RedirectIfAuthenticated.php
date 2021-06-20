<?php

namespace App\Http\Middleware;

use App\Enums\GuardType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard == GuardType::BUSINESS && Auth::guard($guard)->check()) return redirect()->route('business.home');
        if ($guard == GuardType::STAFF && Auth::guard($guard)->check()) return  redirect()->route('staff.home');
        if ($guard == GuardType::ADMIN && Auth::guard($guard)->check()) return redirect()->route('admin.home');
        return $next($request);
    }
}
