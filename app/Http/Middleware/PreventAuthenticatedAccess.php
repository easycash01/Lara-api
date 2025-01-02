<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class PreventAuthenticatedAccess
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $credentials = $request->only(['email', 'password']);
        $email = $credentials['email'] ?? null;

        if ($email && Cache::has('user_logged_' . $email)) {
            return response()->json([
                'error' => 'Questo utente è già autenticato. Devi fare logout prima di poter fare una nuova login.',
                'already_authenticated' => true
            ], 400);
        }

        return $next($request);
    }
} 