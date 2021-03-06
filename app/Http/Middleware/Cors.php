<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $domains =['http://localhost:4200','http://wphackstop.com'];
        if(isset($request->server()['HTTP_ORIGIN'])){
            $origin = $request->server()['HTTP_ORIGIN'];
            
            if(in_array($origin, $domains)){
                header('Access-Control-Allow-Origin: '.$origin);
                //header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization,X-Auth-Token');
                header('Access-Control-Allow-Headers: Content-Type, x-xsrf-token, x_csrftoken,token,Authorization');
            }

        }
        return $next($request);
    }
}
