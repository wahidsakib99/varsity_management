<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class teachermiddleware
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
        if((Session::has('teacher')) == false)
        {
            return back(); 
        }
        return $next($request);
    }
}
