<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $allowedOrigins = [
            'https://esame-angular.onrender.com',
            'https://esame-laravel.onrender.com',
            'http://localhost:4200',
        ];

        $requestOrigin = $request->headers->get('Origin');

        if (in_array($requestOrigin, $allowedOrigins)) {
            $response = $next($request);
            $response->headers->set('Access-Control-Allow-Origin', $requestOrigin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
            return $response;
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
