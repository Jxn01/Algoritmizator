<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PageController extends Controller
{

    public function showDashboard()
    {
        return Inertia::render('Dashboard', ['title' => 'Vezérlőpult', 'activeTab' => 'dashboard', 'user' => Auth::user()]);
    }

    public function showAuth($type)
    {
        if ($type === 'login') {
            return Inertia::render('Login', ['title' => 'Bejelentkezés', 'activeTab' => 'login', 'user' => Auth::user()]);
        }
        if ($type === 'registration') {
            return Inertia::render('Registration', ['title' => 'Regisztráció', 'activeTab' => 'registration', 'user' => Auth::user()]);
        }
        if ($type === 'forgot-password') {
            return Inertia::render('ForgotPassword', ['title' => 'Elfelejtett jelszó', 'activeTab' => 'login', 'user' => Auth::user()]);
        }
        if ($type === 'reset-password') {
            return Inertia::render('ResetPasswordPage', ['title' => 'Jelszó visszaállítása', 'activeTab' => 'login', 'user' => Auth::user()]);
        }

        return Inertia::render('NotFound', ['title' => '404', 'user' => Auth::user()]);
    }

    public function showLogout(){
        return Inertia::render('Logout', ['title' => 'Kijelentkezés', 'activeTab' => 'logout', 'user' => Auth::user()]);
    }

    public function showConfirmEmail(){
        return Inertia::render('VerificationEmailSent', ['title' => 'E-mail cím megerősítése', 'registration' => 'dashboard', 'user' => Auth::user()]);
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
