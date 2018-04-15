<?php

namespace App\Http\Middleware;

use Closure;

class must_be_admin
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
        // check if there authenticated user and admin

        if(auth()->check() && auth()->user()->is_admin)

            return $next($request);

        return response('action not allowed' , 401);

    }
}
