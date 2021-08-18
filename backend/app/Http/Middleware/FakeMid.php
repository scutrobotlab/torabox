<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FakeMid
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
        if (!App::environment(['local', 'staging'])) {
            return response()->json([
                'message' => 'Forbbiden',
            ], 403);
        }
        return $next($request);
    }
}
