<?php

namespace App\Http\Middleware;

use App\Enums\GuardType;
use Closure;
use Illuminate\Http\Request;

class RedirectIfNotBusiness
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard(GuardType::BUSINESS)->check()) return redirect(route('business.login.form'));
        return $next($request);
    }
}
