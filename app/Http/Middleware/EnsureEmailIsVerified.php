<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    use RespondsWithHttpStatus;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user's email is verified
        if (!Auth::user()->hasVerifiedEmail()) {
            return response()->json(['success' => false,'message' => 'Email not verified, Please verify first'], 403);
        }

        return $next($request);
    }
}
