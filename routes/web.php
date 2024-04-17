<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login.login');
});

Route::get('/login', function () {
    return view('login.login');
})->name('login');

Route::get('/logout', function () {
    return view('login.logout');
})->name('logout');

Route::get('/registration', function () {
    return view('login.registration');
})->name('registration');

Route::get('/registration/confirm-email', function () {
    return view('login.verification-email-sent');
})->name('confirm-email');

Route::get('/login/forgot-password', function () {
    return view('login.forgot-password');
})->name('forgot-password');

Route::get('/login/reset-password', function () {
    return view('login.reset-password');
})->name('reset-password');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/profile', function () {
    return view('profile.profile');
})->name('profile');

Route::get('/social', function () {
    return view('socials.socials');
})->name('social');

Route::get('/lessons', function () {
    return view('lessons.lessons');
})->name('lessons');

Route::get('/lessons/lesson/quiz', function () {
    return view('lessons.quiz');
})->name('quiz');

Route::get('/lessons/lesson/quiz/result', function () {
    return view('lessons.quiz-results');
})->name('quiz-result');

Route::fallback(function () {
    return view('errors.404');
});
