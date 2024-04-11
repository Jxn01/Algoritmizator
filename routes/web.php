<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login.login');
});

Route::get('/login', function () {
    return view('login.login');
})->name('login');

Route::get('/registration', function () {
    return view('login.registration');
})->name('registration');

Route::get('/registration/confirm-email', function () {
    return view('login.confirm-email');
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

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/social', function () {
    return view('socials.social');
})->name('social');

Route::get('/social/friend-requests', function () {
    return view('socials.friend-requests');
})->name('friend-requests');

Route::get('/social/friends', function () {
    return view('socials.friends');
})->name('friends');

Route::get('/social/search-friends', function () {
    return view('socials.search-friends');
})->name('search-friends');

Route::get('/social/friend-profile', function () {
    return view('socials.friend-profile');
})->name('friend-profile');

Route::get('/lessons', function () {
    return view('lessons.lessons');
})->name('lessons');

Route::get('/lessons/lesson', function () {
    return view('lessons.lesson');
})->name('lesson');

Route::get('/lessons/lesson/quiz', function () {
    return view('lessons.assignment');
})->name('quiz');

Route::get('/lessons/lesson/quiz/result', function () {
    return view('lessons.assignment-complete');
})->name('quiz-result');

Route::fallback(function () {
    return view('errors.404');
});
