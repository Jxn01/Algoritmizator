<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RedirectFromOwnProfile
 *
 * The RedirectFromOwnProfile middleware is used to handle redirections from a user's own profile.
 * If a user tries to access their own profile using the profile ID in the URL, they are redirected to the general profile page.
 */
class RedirectFromOwnProfile
{
    /**
     * Handle an incoming request.
     *
     * This method checks if the authenticated user is trying to access their own profile using the profile ID in the URL.
     * If so, it redirects them to the general profile page.
     * Otherwise, it allows the request to proceed.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @param  Closure  $next  The next middleware in the stack.
     * @return Response The response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && $user->id === (int) $request->route('id')) {
            return redirect()->route('profile');
        }

        return $next($request);
    }
}
