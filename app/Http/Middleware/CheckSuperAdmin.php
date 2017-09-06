<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class CheckSuperAdmin
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {
           
        if ($this->auth->guest()) {
          return redirect()->guest('/');
        }else{

            if(Auth::user()->userMeta->role == '1'){
                return $next($request);
            }else{
                return redirect()->guest('/');
            }           
        }
        return $next($request);
    }
}
