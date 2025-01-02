<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type): Response
    {
        try {
            // Decodifica il token
            $decoded = JWTAuth::parseToken()->getPayload();

            // Controlla il claim 'type'
            if ($decoded->get('type') !== $type) {
                return response()->json(['error' => 'Tipo di utente non autorizzato'], 403);
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token non valido o mancante'], 401);
        }
    }
}
