<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function showDashboard()
    {
        return Inertia::render('Dashboard');
    }

    public function showAuth($type)
    {
        if ($type === 'login') {
            return Inertia::render('Login');
        }
        if ($type === 'logout') {
            return Inertia::render('Logout');
        }
        if ($type === 'registration') {
            return Inertia::render('Registration');
        }
        if ($type === 'confirm-email') {
            return Inertia::render('VerificationEmailSent');
        }
        if ($type === 'forgot-password') {
            return Inertia::render('ForgotPassword');
        }
        if ($type === 'reset-password') {
            return Inertia::render('ResetPasswordPage');
        }

        return Inertia::render('NotFound');
    }

    public function showError($type)
    {
        if ($type === '404') {
            return Inertia::render('NotFound');
        }
        if ($type === '403') {
            return Inertia::render('Forbidden');
        }
        if ($type === '500') {
            return Inertia::render('InternalServerError');
        }

        return Inertia::render('NotFound');
    }

    public function showNotFound()
    {
        return Inertia::render('NotFound');
    }

    public function showProfile()
    {
        return Inertia::render('Profile');
    }

    public function showSocials()
    {
        return Inertia::render('Socials');
    }

    public function showLessons()
    {
        return Inertia::render('Lessons');
    }

    public function showAlgorithm($id)
    {
        return Inertia::render('Algorithm', ['id' => $id]);
    }

    public function showQuiz($id)
    {
        return Inertia::render('Quiz', ['id' => $id]);
    }

    public function showQuizResult($id)
    {
        return Inertia::render('QuizResult', ['id' => $id]);
    }
}
