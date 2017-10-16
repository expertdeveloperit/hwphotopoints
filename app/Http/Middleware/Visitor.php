<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Visitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request,Closure $next)
    {   
        if(Auth::user()->role == 3){
            return response()->json(['error' => "Your can't access this area.",'status'=>false]);
        }

        return $next($request);
    }
}
