<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        # Ne pas mettre en cache pour éviter l'accès à des données sensible via le
        # cache du navigateur meme après la déconnexion d'un utilisateur
        $response->header("Cache-control", "no-cache, no-store, max-age=0, must-revalidate");

        return $response;
    }
}
