<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

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
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, HEAD, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Access-Control-Allow-Origin, Content-Type, Authorization, X-Requested-With, Accept, Accept-Encoding, Accept-Language, Access-Control-Request-Headers, Access-Control-Request-Method, Connection, Host, Origin, User-Agent');
    }
}
