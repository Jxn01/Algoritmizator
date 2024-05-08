<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    public function showDashboard()
    {
        return Inertia::render('Dashboard', ['title' => 'Vezérlőpult', 'activeTab' => 'dashboard', 'user' => Auth::user()]);
    }

    /**
     * Show the login page.
     *
     * @return Response
     */
    public function showLogin()
    {
        return Inertia::render('Login', ['title' => 'Bejelentkezés', 'activeTab' => 'login', 'user' => Auth::user()]);
    }

    /**
     * Show the registration page.
     *
     * @return Response
     */
    public function showRegistration()
    {
        return Inertia::render('Registration', ['title' => 'Regisztráció', 'activeTab' => 'registration', 'user' => Auth::user()]);
    }

    /**
     * Show the forgot password page.
     *
     * @return Response
     */
    public function showForgotPassword()
    {
        return Inertia::render('ForgotPassword', ['title' => 'Elfelejtett jelszó', 'activeTab' => 'login', 'user' => Auth::user()]);
    }

    /**
     * Show the reset password page.
     *
     * @param  string  $token  The password reset token.
     * @return Response
     */
    public function showResetPassword($token)
    {
        return Inertia::render('PasswordReset', ['title' => 'Jelszó visszaállítása', 'activeTab' => 'login', 'user' => Auth::user(), 'token' => $token]);
    }

    /**
     * Show the logout page.
     *
     * @return Response
     */
    public function showLogout()
    {
        return Inertia::render('Logout', ['title' => 'Kijelentkezés', 'activeTab' => 'logout', 'user' => Auth::user()]);
    }

    /**
     * Show the email confirmed page.
     *
     * @return Response
     */
    public function showEmailConfirmed()
    {
        return Inertia::render('EmailConfirmation', ['title' => 'E-mail cím megerősítve', 'activeTab' => 'registration', 'user' => Auth::user()]);
    }

    /**
     * Show the confirm email page.
     *
     * @return Response
     */
    public function showConfirmEmail()
    {
        return Inertia::render('VerificationEmailSent', ['title' => 'E-mail cím megerősítése', 'activeTab' => 'registration', 'user' => Auth::user()]);
    }

    /**
     * Show the error page.
     *
     * @param  string  $type  The type of error (404, 403, 500).
     * @return Response
     */
    public function showError($type)
    {
        if ($type === '404') {
            return Inertia::render('NotFound', ['title' => '404', 'user' => Auth::user()]);
        }
        if ($type === '403') {
            return Inertia::render('Forbidden', ['title' => '403', 'user' => Auth::user()]);
        }
        if ($type === '500') {
            return Inertia::render('InternalServerError', ['title' => '500', 'user' => Auth::user()]);
        }

        return Inertia::render('NotFound', ['title' => '404', 'user' => Auth::user()]);
    }

    /**
     * Show the not found page.
     *
     * @return Response
     */
    public function showNotFound()
    {
        return Inertia::render('NotFound', ['title' => '404', 'user' => Auth::user()]);
    }

    /**
     * Show the profile page.
     *
     * @return Response
     */
    public function showProfile()
    {
        return Inertia::render('Profile', ['title' => 'Profilom', 'activeTab' => 'profile', 'user' => Auth::getUser()]);
    }

    /**
     * Show the socials page.
     *
     * @return Response
     */
    public function showSocials()
    {
        return Inertia::render('Socials', ['title' => 'Közösség', 'activeTab' => 'socials', 'user' => Auth::getUser()]);
    }

    /**
     * Show the user profile page.
     *
     * @param  int  $id  The ID of the user whose profile to show.
     * @return Response
     */
    public function showUserProfile($id)
    {
        $user = User::findById($id);

        return Inertia::render('UserProfile', ['title' => 'Profil', 'activeTab' => 'socials', 'user' => Auth::getUser(), 'profileUser' => $user]);
    }

    /**
     * Show the lessons page.
     *
     * @return Response
     */
    public function showLessons()
    {
        return Inertia::render('Lessons', ['title' => 'Tananyag', 'activeTab' => 'lessons', 'user' => Auth::getUser()]);
    }

    /**
     * Show the algorithm page.
     *
     * @param  int  $id  The ID of the algorithm to show.
     * @return Response
     */
    public function showAlgorithm($id)
    {
        return Inertia::render('Algorithm', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons', 'user' => Auth::getUser()]);
    }

    /**
     * Show the quiz page.
     *
     * @param  int  $id  The ID of the quiz to show.
     * @return Response
     */
    public function showQuiz($id)
    {
        return Inertia::render('Quiz', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons', 'user' => Auth::getUser()]);
    }

    /**
     * Show the quiz result page.
     *
     * @param  int  $id  The ID of the quiz whose result to show.
     * @return Response
     */
    public function showQuizResult($id)
    {
        return Inertia::render('QuizResult', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons', 'user' => Auth::getUser()]);
    }
}
