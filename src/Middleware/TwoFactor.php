<?php

namespace MabenDev\TwoFactor\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check()) return $next($request);

        if(!Auth::user()->hasTwoFactor()) return $next($request);

        if(session()->has('2fa') && session()->get('2fa') === true) {
            return $next($request);
        }

        return redirect()->route('2fa-form');
    }
}
