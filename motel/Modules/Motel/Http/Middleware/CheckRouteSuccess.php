<?php

namespace Modules\Motel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class CheckRouteSuccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        if(Session::has('message')){
            return $next($request);
        }else{
            abort(404);
        }   
    }
}
