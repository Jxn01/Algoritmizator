<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Class PageController
 *
 * The PageController handles the rendering of different pages in the application.
 * It uses the Inertia.js library to render Vue.js components from the server-side.
 */
class PageController extends Controller
{
    /**
     * Show the dashboard page.
     *
     * @return Response
     */
    public function showDashboard(): Response
    {
        return Inertia::render('Dashboard', ['title' => 'Vezérlőpult', 'activeTab' => 'dashboard']);
    }

    /**
     * Show the login page.
     *
     * @return Response
     */
    public function showLogin(): Response
    {
        return Inertia::render('Login', ['title' => 'Bejelentkezés', 'activeTab' => 'login']);
    }

    /**
     * Show the registration page.
     *
     * @return Response
     */
    public function showRegistration(): Response
    {
        return Inertia::render('Registration', ['title' => 'Regisztráció', 'activeTab' => 'registration']);
    }

    /**
     * Show the forgot password page.
     *
     * @return Response
     */
    public function showForgotPassword(): Response
    {
        return Inertia::render('ForgotPassword', ['title' => 'Elfelejtett jelszó', 'activeTab' => 'login']);
    }

    /**
     * Show the reset password page.
     *
     * @param string $token  The password reset token.
     * @return Response
     */
    public function showResetPassword(string $token): Response
    {
        return Inertia::render('PasswordReset', ['title' => 'Jelszó visszaállítása', 'activeTab' => 'login', 'token' => $token]);
    }

    /**
     * Show the logout page.
     *
     * @return Response
     */
    public function showLogout(): Response
    {
        return Inertia::render('Logout', ['title' => 'Kijelentkezés', 'activeTab' => 'logout']);
    }

    /**
     * Show the email confirmed page.
     *
     * @return Response
     */
    public function showEmailConfirmed(): Response
    {
        return Inertia::render('EmailConfirmation', ['title' => 'E-mail cím megerősítve', 'activeTab' => 'registration']);
    }

    /**
     * Show the confirm email page.
     *
     * @return Response
     */
    public function showConfirmEmail(): Response
    {
        return Inertia::render('VerificationEmailSent', ['title' => 'E-mail cím megerősítése', 'activeTab' => 'registration']);
    }

    /**
     * Show the error page.
     *
     * @param  string  $type  The type of error (404, 403, 500).
     * @return Response
     */
    public function showError($type): Response
    {
        if ($type === '404') {
            return Inertia::render('NotFound', ['title' => '404']);
        }
        if ($type === '403') {
            return Inertia::render('Forbidden', ['title' => '403']);
        }
        if ($type === '500') {
            return Inertia::render('InternalServerError', ['title' => '500']);
        }

        return Inertia::render('NotFound', ['title' => '404']);
    }

    /**
     * Show the not found page.
     *
     * @return Response
     */
    public function showNotFound(): Response
    {
        return Inertia::render('NotFound', ['title' => '404']);
    }

    /**
     * Show the profile page.
     *
     * @return Response
     */
    public function showProfile(): Response
    {
        return Inertia::render('Profile', ['title' => 'Profilom', 'activeTab' => 'profile']);
    }

    /**
     * Show the socials page.
     *
     * @return Response
     */
    public function showSocials(): Response
    {
        return Inertia::render('Socials', ['title' => 'Közösség', 'activeTab' => 'socials']);
    }

    /**
     * Show the user profile page.
     *
     * @param  int  $id  The ID of the user whose profile to show.
     * @return Response
     */
    public function showUserProfile($id): Response
    {
        return Inertia::render('UserProfile', ['title' => 'Profil', 'activeTab' => 'socials', 'id' => $id]);
    }

    /**
     * Show the lessons page.
     *
     * @return Response
     */
    public function showLessons(): Response
    {
        return Inertia::render('Lessons', ['title' => 'Tananyag', 'activeTab' => 'lessons']);
    }

    /**
     * Show the quiz page.
     *
     * @param  int  $id  The ID of the quiz to show.
     * @return Response
     */
    public function showTask($id): Response
    {
        return Inertia::render('Task', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons']);
    }

    /**
     * Show the quiz result page.
     *
     * @param  int  $id  The ID of the quiz whose result to show.
     * @return Response
     */
    public function showTaskAttempt($id): Response
    {
        return Inertia::render('TaskAttempt', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons']);
    }
}
