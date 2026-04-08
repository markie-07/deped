<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = env('INTERNAL_API_TOKEN');
        $providedToken = $request->bearerToken();
        
        \Illuminate\Support\Facades\Log::info('Incoming Sync Request', [
            'url' => $request->fullUrl(),
            'token_match' => ($providedToken === $token)
        ]);

        if (!$token) {
            return $next($request);
        }

        if ($providedToken !== $token) {
            return response()->json([
                'message' => 'Unauthorized. Invalid API Token.'
            ], 401);
        }

        return $next($request);
    }
}
