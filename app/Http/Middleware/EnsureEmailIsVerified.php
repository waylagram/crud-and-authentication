<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $redirectToRoute=null): Response
    {
        if (
            $request->user() && !$request->user()->hasVerifiedEmail() && !$request->is('email/verify', 'logout')
        ) {
            return $request->expectsJson() ? abort(403, 'Your email address is not verified') : redirect($redirectToRoute ?: 'email/verify');
        }

        return $next($request);
    }
}
