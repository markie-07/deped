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
        $providedToken = $request->bearerToken();
        $isRecordPath = $request->is('api/leave-records*');
        
        $token = $isRecordPath 
            ? env('INTERNAL_RECORD_TOKEN', env('INTERNAL_API_TOKEN'))
            : env('INTERNAL_USER_TOKEN', env('INTERNAL_API_TOKEN'));

        \Illuminate\Support\Facades\Log::info('Incoming Sync Request', [
            'url' => $request->fullUrl(),
            'path' => $request->path(),
            'type' => $isRecordPath ? 'Record' : 'User',
            'token_match' => ($providedToken === $token)
        ]);

        if (!$token) {
            return $next($request);
        }

        if ($providedToken !== $token) {
            return response()->json([
                'message' => 'Unauthorized. Invalid API Token for ' . ($isRecordPath ? 'Records' : 'Users') . '.'
            ], 401);
        }

        return $next($request);
    }
}
