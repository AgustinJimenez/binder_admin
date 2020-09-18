<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class VerifyResponsableMiddleware
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
        if ( !$re->filled('responsable_access_token') )
            return response()->json(['error' => true, 'message' => 'No se encuentra token de responsable.', 'error_tag' => 'middleware-api', 'debug-message' => $re->all() ]);
        else if ( 
                    !\ResponsableAccess::where('token', $re->responsable_access_token )
                    ->whereHas('responsable', function( $responsable_q ) use ($re)
                    {
                        $responsable_q->where('estado', 'aprobado');

                        if( $re->filled("colegio_token") )
                            $responsable_q->whereHas('user.colegio', function( $colegio_q ) use ($re)
                            {
                                $colegio_q->where("token", $re->colegio_token );
                            });
                    })
                    ->exists() 
                )
            return response()->json(['error' => true, 'message' => 'Error, token de responsable invalido o no aprobado.', 'error_tag' => 'middleware-api', 'debug-message' => $re->all() ]);
        else
        {
            $access = \ResponsableAccess::where('token', $re['responsable_access_token'])->first();
            $re['responsable_id'] = $access->responsable_id;
            $re['responsable'] = $access->responsable;
            return $next($re);
        }
            
        
    }
}
