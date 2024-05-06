<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PageController extends Controller
{
    public function showDashboard()
    {
        return Inertia::render('Dashboard', ['title' => 'Vezérlőpult', 'activeTab' => 'dashboard', 'user' => Auth::user()]);
    }

    public function showLogin()
    {
        return Inertia::render('Login', ['title' => 'Bejelentkezés', 'activeTab' => 'login', 'user' => Auth::user()]);
    }

    public function showRegistration()
    {
        return Inertia::render('Registration', ['title' => 'Regisztráció', 'activeTab' => 'registration', 'user' => Auth::user()]);
    }

    public function showForgotPassword()
    {
        return Inertia::render('ForgotPassword', ['title' => 'Elfelejtett jelszó', 'activeTab' => 'login', 'user' => Auth::user()]);
    }

    public function showResetPassword($token)
    {
        return Inertia::render('PasswordReset', ['title' => 'Jelszó visszaállítása', 'activeTab' => 'login', 'user' => Auth::user(), 'token' => $token]);
    }

    public function showLogout()
    {
        return Inertia::render('Logout', ['title' => 'Kijelentkezés', 'activeTab' => 'logout', 'user' => Auth::user()]);
    }

    public function showEmailConfirmed()
    {
        return Inertia::render('EmailConfirmation', ['title' => 'E-mail cím megerősítve', 'activeTab' => 'registration', 'user' => Auth::user()]);
    }

    public function showConfirmEmail()
    {
        return Inertia::render('VerificationEmailSent', ['title' => 'E-mail cím megerősítése', 'activeTab' => 'registration', 'user' => Auth::user()]);
    }

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

    public function showNotFound()
    {
        return Inertia::render('NotFound', ['title' => '404', 'user' => Auth::user()]);
    }

    public function showProfile()
    {
        return Inertia::render('Profile', ['title' => 'Profilom', 'activeTab' => 'profile', 'user' => Auth::getUser()]);
    }

    public function showSocials()
    {
        return Inertia::render('Socials', ['title' => 'Közösség', 'activeTab' => 'socials', 'user' => Auth::getUser()]);
    }

    public function showUserProfile($id)
    {
        $user = User::findById($id);
        return Inertia::render('UserProfile', ['title' => 'Profil', 'activeTab' => 'socials', 'user' => Auth::getUser(), 'profileUser' => $user]);
    }

    public function showLessons()
    {
        return Inertia::render('Lessons', ['title' => 'Tananyag', 'activeTab' => 'lessons', 'user' => Auth::getUser()]);
    }

    public function showAlgorithm($id)
    {
        return Inertia::render('Algorithm', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons', 'user' => Auth::getUser()]);
    }

    public function showQuiz($id)
    {
        return Inertia::render('Quiz', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons', 'user' => Auth::getUser()]);
    }

    public function showQuizResult($id)
    {
        return Inertia::render('QuizResult', ['id' => $id, 'title' => 'Tananyag', 'activeTab' => 'lessons', 'user' => Auth::getUser()]);
    }
}
