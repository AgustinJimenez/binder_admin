<?php

namespace Modules\Colegios\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class SessionHasColegioToken
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
        //dd( !session()->has('colegio_token') , !\Colegio::where('token', session()->get('colegio_token') )->exists() );
        if ( !session()->has('colegio_token') or !\Colegio::where('token', session()->get('colegio_token') )->exists() )
		{
			$last_error = 'Debe establecer un colegio para proceder.';
			//session(compact('last_error'));
            //flash()->error($last_error);
            //abort(403, $last_error);
            return redirect()
                    ->route("admin.colegios.colegio.index")
                    ->withError($last_error);
		}
        return $next($request);
    }
}
