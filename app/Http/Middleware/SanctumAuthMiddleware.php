<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class SanctumAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => 'Token not provided'
            ], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json([
                'error' => 'Invalid token'
            ], 401);
        }

        // Check if token is expired
        if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {
            $accessToken->delete();
            return response()->json([
                'error' => 'Token expired'
            ], 401);
        }

        // Authenticate user using Auth facade
        $user = $accessToken->tokenable;
        Auth::setUser($user); // Use Auth::setUser() instead of auth()->setUser()

        // Update token last_used_at
        $accessToken->forceFill([
            'last_used_at' => now(),
        ])->save();

        return $next($request);
    }
}