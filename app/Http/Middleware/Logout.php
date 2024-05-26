<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Logout
 *
 * The Logout middleware is used to handle the logout process.
 * It logs the user out of the system and invalidates the session.
 */
class Logout
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $next($request);
    }
}
