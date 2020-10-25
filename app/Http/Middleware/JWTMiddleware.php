<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
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
        $message = '';

        try{
            JWTAuth::parsetoken()->authenticate();
            return $next($request);
        } catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
           $message = 'Token Expired'; 
        }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            $message = 'Invalid Token'; 
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            $message = 'Provide a Token!'; 
        }
        return response()->json([
            'success'=>false,
            'message'=>$message
        ]);
    }
}
