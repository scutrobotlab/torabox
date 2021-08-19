<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserInGroup
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
        if (!UserMid::$user->isGroupUser($request->group_id)) {
            return response()->json([
                'message' => '需要本组成员执行操作',
            ], 403);
        }

        return $next($request);
    }
}
