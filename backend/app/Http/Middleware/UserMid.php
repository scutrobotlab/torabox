<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMid
{
    public static $user;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user')) {
            return response()->json([
                'msg' => 'Unauthority',
            ], 401);
        }
        self::$user = session('user');
        return $next($request);
    }
}
