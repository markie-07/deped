<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->is_active) {
            Log::warning('Deactivating session for user: ' . Auth::id());
            /** @var \Illuminate\Auth\SessionGuard $guard */
            $guard = Auth::guard();
            $guard->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your account has been deactivated.'], 403);
            }
            
            return redirect('/')->with('error', 'Your account has been deactivated. Please contact an administrator.');
        }

        return $next($request);
    }
}
