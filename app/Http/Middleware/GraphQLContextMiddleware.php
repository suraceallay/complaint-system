<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GraphQLContextMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Add user and token to request for GraphQL context
        if (Auth::check()) {
            $request->merge([
                'graphql_user' => Auth::user(),
                'graphql_token' => $request->bearerToken(),
            ]);
        }

        return $next($request);
    }
}