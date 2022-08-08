<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
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
        try{
            $user = JWTAuth::parseToken()->authenticate();
        }catch(Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return \response()->json([
                    'status' => 403,
                    'message' => 'Invalid Token'
                ], 403);
                //]);
            }
            else{
                if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return \response()->json([
                        'status' => 403,
                        'message' => 'Token expired'
                    ], 403);
                    //]);
                }
                else{
                    return \response()->json([
                        'status' => 403,
                        'message' => 'Token is required'
                    ], 403);
                    //]);
                }
            }
        }
        return $next($request->merge(['login' => $user]));
    }
}
