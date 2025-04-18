<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $userId = $request->header('User-Id');

        if ($token && $userId) {
            if (Auth::check() && Auth::id() == $userId) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

