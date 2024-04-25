<?php

use App\Http\Controllers\PageController;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Route;

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/app', [PageController::class, 'showDashboard'])->name('dashboard');
});

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/auth/{type}', [PageController::class, 'showAuth'])->name('auth');
});

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/error/{type}', [PageController::class, 'showError'])->name('error');
});

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/app/profile', [PageController::class, 'showProfile'])->name('profile');
});

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/app/socials', [PageController::class, 'showSocials'])->name('socials');
});

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/app/algorithms', [PageController::class, 'showLessons'])->name('lessons');
});

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/app/algorithms/{id}', [PageController::class, 'showAlgorithm'])->name('algorithm');
});

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/app/algorithms/{id}/quiz', [PageController::class, 'showQuiz'])->name('quiz');
});

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/algoritmizator/app/algorithms/{id}/quiz/result', [PageController::class, 'showQuizResult'])->name('quiz-result');
});

Route::fallback([PageController::class, 'showNotFound']);
