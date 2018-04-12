<?php

namespace App\Http\Middleware;

use Closure;

class must_be_supervisor
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
        // check if there authenticated user and supervisor

        if(auth()->check() && auth()->user()->is_supervisor)

            return $next($request);

        return response('action not allowed' , 401);


    }
}
