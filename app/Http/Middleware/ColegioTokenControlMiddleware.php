<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;
class ColegioTokenControlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $re, Closure $next)
    {
        //return ['error' => true, 'message' => 'here', 'debug-message' => $re->all() ];

        if ( !$re->filled('colegio_token') )
            return response()->json(['error' => true, 'message' => 'Error, no se encuentra colegio token.', 'error_tag' => 'middleware-api']);
        else if ( !\Colegio::where('token', $re->colegio_token )->exists() )
            return response()->json(['error' => true, 'message' => 'Error, colegio token invalido.', 'error_tag' => 'middleware-api']);
        else
            return $next($re);
        
    }
}
