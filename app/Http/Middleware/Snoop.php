<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Snoop
 *
 * The Snoop middleware updates the user's last online status and activity.
 */
class Snoop
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $user->last_online = Carbon::now();
            $user->is_online = true;

            $route = $request->route()->getName();

            switch ($route) {
                case 'profile':
                    $user->last_seen_at = 'Saját profil';
                    $user->last_activity = 'Éppen a profilját nézegeti.';
                    break;
                case 'socials':
                    $user->last_seen_at = 'Közösség';
                    $user->last_activity = 'A Közösség fület nézegeti.';
                    break;
                case 'user-profile':
                    $user->last_seen_at = 'Felhasználói profil';
                    $user->last_activity = 'Mások profiljait nézegeti.';
                    break;
                case 'quiz':
                    $user->last_seen_at = 'Kvíz';
                    $user->last_activity = 'Kvízt tölt ki.';
                    break;
                case 'quiz-result':
                    $user->last_seen_at = 'Kvíz eredmények';
                    $user->last_activity = 'Kvíz eredményeket nézeget.';
                    break;
                case 'lessons':
                    $user->last_seen_at = 'Leckék';
                    $user->last_activity = 'Leckéket nézeget.';
                    break;
                case 'logout':
                    $user->last_seen_at = 'Kijelentkezés';
                    $user->last_activity = 'Kijelentkezik.';
                    break;
                case 'dashboard1':
                case 'dashboard2':
                    $user->last_seen_at = 'Irányítópult';
                    $user->last_activity = 'Az irányítópultot nézegeti.';
                    break;
                default:
                    $user->last_seen_at = 'Ismeretlen';
                    $user->last_activity = 'Valahol a weboldalon bóklászik.';
                    break;
            }

            $user->save();
        }

        return $next($request);
    }
}
