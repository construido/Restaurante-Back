<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CajeroMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->get('login');
        if($user['Estado_Login'] != '1' and $user['Estado_Login'] != '2'){
            return \response()->json([
                'status' => false,
                'error' => 'Permise denied, sólo cajero y administrador'
            ]);
        }
        return $next($request);
    }
}
