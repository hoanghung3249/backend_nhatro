<?php

namespace Modules\Motel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MotelAuthorisedApiKey
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
        if ($request->header('MT-API-KEY') === null) {

            // If the request wants JSON (AJAX doesn't always want JSON)
            if ($request->wantsJson()) {
                return response()->json([
                    'status'=> false,
                    "status_code"=> 403,
                    "message"=> 'Unauthorized',
                    "data"=>[]
                ], 200);
            }
            else{
                return new Response('Forbidden', 403);
            }
        }
        if ($this->isValidApiKey($request->header('MT-API-KEY')) === false) {
            // If the request wants JSON (AJAX doesn't always want JSON)
            if ($request->wantsJson()) {
                return response()->json([
                    'status'=> false,
                    "status_code"=> 403,
                    "message"=> 'Unauthorized',
                    "data"=>[]
                ], 200);
            }
            else{
                return new Response('Forbidden', 403);
            }
        }

        return $next($request);
    }
    private function isValidApiKey($apiKey){
        if($apiKey !== config('motel.MT-API-KEY')){
            return false;
        }
        return true;
    }

    private function parseToken($token)
    {
        return str_replace('Bearer ', '', $token);
    }
}
