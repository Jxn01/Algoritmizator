<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/algoritmizator/app');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/algoritmizator/api/auth/email-verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('inertia')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/algoritmizator/app/profile', [PageController::class, 'showProfile']);
        Route::get('/algoritmizator/app/socials', [PageController::class, 'showSocials']);
        Route::get('/algoritmizator/app/lessons/{id}/quiz', [PageController::class, 'showQuiz']);
        Route::get('/algoritmizator/app/lessons/{id}/quiz/result', [PageController::class, 'showQuizResult']);
    });

    Route::post('/algoritmizator/api/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('/algoritmizator/auth/logout', [PageController::class, 'showLogout'])->middleware('auth');

    Route::middleware('guest')->group(function () {
        Route::get('/algoritmizator/auth/{type}', [PageController::class, 'showAuth']);
        Route::get('/algoritmizator/auth/confirm-email', [PageController::class, 'showConfirmEmail'])->name('verification.notice');
        Route::post('/algoritmizator/api/login', [AuthController::class, 'login']);
        Route::post('/algoritmizator/api/register', [AuthController::class, 'register']);
    });

    Route::get('/algoritmizator/', [PageController::class, 'showDashboard']);
    Route::get('/algoritmizator/app', [PageController::class, 'showDashboard']);
    Route::get('/algoritmizator/app/lessons', [PageController::class, 'showLessons']);
    Route::get('/algoritmizator/app/lessons/{id}', [PageController::class, 'showAlgorithm']);
    Route::get('/algoritmizator/error/{type}', [PageController::class, 'showError']);

    Route::fallback([PageController::class, 'showNotFound']);
});
