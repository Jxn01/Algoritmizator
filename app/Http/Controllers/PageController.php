<?php

namespace App\Http\Controllers;

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
     */
    public function showDashboard(): Response
    {
        return Inertia::render('Dashboard', ['title' => 'Vezérlőpult', 'activeTab' => 'dashboard']);
    }

    /**
     * Show the login page.
     */
    public function showLogin(): Response
    {
        return Inertia::render('Login', ['title' => 'Bejelentkezés', 'activeTab' => 'login']);
    }

    /**
     * Show the registration page.
     */
    public function showRegistration(): Response
    {
        return Inertia::render('Registration', ['title' => 'Regisztráció', 'activeTab' => 'registration']);
    }

    /**
     * Show the forgot password page.
     */
    public function showForgotPassword(): Response
    {
        return Inertia::render('ForgotPassword', ['title' => 'Elfelejtett jelszó', 'activeTab' => 'login']);
    }

    /**
     * Show the reset password page.
     *
     * @param  string  $token  The password reset token.
     */
    public function showResetPassword(string $token): Response
    {
        return Inertia::render('PasswordReset', ['title' => 'Jelszó visszaállítása', 'activeTab' => 'login', 'token' => $token]);
    }

    /**
     * Show the logout page.
     */
    public function showLogout(): Response
    {

        return Inertia::render('Logout', ['title' => 'Kijelentkezés', 'activeTab' => 'logout']);
    }

    /**
     * Show the email confirmed page.
     */
    public function showEmailConfirmed(): Response
    {
        return Inertia::render('EmailConfirmation', ['title' => 'E-mail cím megerősítve', 'activeTab' => 'registration']);
    }

    /**
     * Show the confirm email page.
     */
    public function showConfirmEmail(): Response
    {
        return Inertia::render('VerificationEmailSent', ['title' => 'E-mail cím megerősítése', 'activeTab' => 'registration']);
    }

    /**
     * Show the error page.
     *
     * @param  string  $type  The type of error (404, 403, 500).
     */
    public function showError(string $type): Response
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
     */
    public function showNotFound(): Response
    {
        return Inertia::render('NotFound', ['title' => '404']);
    }

    /**
     * Show the profile page.
     */
    public function showProfile(): Response
    {
        return Inertia::render('Profile', ['title' => 'Profilom', 'activeTab' => 'profile']);
    }

    /**
     * Show the socials page.
     */
    public function showSocials(): Response
    {
        return Inertia::render('Socials', ['title' => 'Közösség', 'activeTab' => 'socials']);
    }

    /**
     * Show the user profile page.
     *
     * @param  int  $id  The ID of the user whose profile to show.
     */
    public function showUserProfile(int $id): Response
    {
        return Inertia::render('UserProfile', ['title' => 'Profil', 'activeTab' => 'socials', 'id' => $id]);
    }

    /**
     * Show the lessons page.
     */
    public function showLessons(): Response
    {
        return Inertia::render('Lessons', ['title' => 'Tananyag', 'activeTab' => 'lessons']);
    }

    /**
     * Show the quiz page.
     *
     * @param  int  $id  The ID of the quiz to show.
     */
    public function showTask(int $id): Response
    {
        return Inertia::render('Task', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons']);
    }

    /**
     * Show the quiz result page.
     *
     * @param  int  $id  The ID of the quiz whose result to show.
     */
    public function showTaskAttempt(int $id): Response
    {
        return Inertia::render('TaskAttempt', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons']);
    }
}
