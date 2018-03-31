<?php

namespace App\Http\Middleware;

use Closure;

class shouldConfirmYourEmail
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
        if(! $request->user()->confirmed)
        {
            return back()->with('message','you should confirm your account first.');
        }

        return $next($request);
    }
}
