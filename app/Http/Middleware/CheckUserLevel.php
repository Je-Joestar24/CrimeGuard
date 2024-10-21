<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$levels  Allowed user levels
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$levels)
    {
        $user = Auth::user(); // Get the authenticated user

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401); // Handle unauthenticated
        }

        // Check if the user's level is in the allowed levels
        if (!in_array($user->user_level, $levels)) {
            return response()->json(['error' => 'Unauthorized access'], 403); // Handle unauthorized access
        }

        return $next($request); // Allow the request to proceed
    }
}

