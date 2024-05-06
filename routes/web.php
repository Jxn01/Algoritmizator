<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::middleware('inertia')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/algoritmizator/app/profile', [PageController::class, 'showProfile'])->name('profile');
        Route::get('/algoritmizator/app/socials', [PageController::class, 'showSocials']);
        Route::get('/algoritmizator/app/socials/{id}/profile', [PageController::class, 'showUserProfile'])->middleware('redirectFromOwnProfile');
        Route::get('/algoritmizator/app/lessons/{id}/quiz', [PageController::class, 'showQuiz']);
        Route::get('/algoritmizator/app/lessons/{id}/quiz/result', [PageController::class, 'showQuizResult']);
        Route::get('/algoritmizator/auth/email-confirmed', [PageController::class, 'showEmailConfirmed']);
        Route::get('/algoritmizator/app/lessons', [PageController::class, 'showLessons']);
    });

    Route::middleware('auth')->group(function () {
        Route::get('/algoritmizator/auth/logout', [PageController::class, 'showLogout']);
        Route::get('/algoritmizator/auth/confirm-email', [PageController::class, 'showConfirmEmail'])->name('verification.notice');
    });

    Route::middleware('guest')->group(function () {
        Route::get('/algoritmizator/auth/login', [PageController::class, 'showLogin'])->name('login');
        Route::get('/algoritmizator/auth/registration', [PageController::class, 'showRegistration']);
        Route::get('/algoritmizator/auth/forgot-password', [PageController::class, 'showForgotPassword'])->name('password.request');
        Route::get('/algoritmizator/auth/reset-password/{token}', [PageController::class, 'showResetPassword'])->name('password.reset');
    });

    Route::get('/algoritmizator/', [PageController::class, 'showDashboard']);
    Route::get('/algoritmizator/app', [PageController::class, 'showDashboard']);
    Route::get('/algoritmizator/error/{type}', [PageController::class, 'showError']);

    Route::fallback([PageController::class, 'showNotFound']);
});

Route::get('/algoritmizator/auth/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/algoritmizator/auth/email-confirmed');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware('auth')->group(function () {
    Route::post('/algoritmizator/api/logout', [AuthController::class, 'logout']);
    Route::post('/algoritmizator/api/email-verification-notification', [AuthController::class, 'emailVerificationNotification'])->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/algoritmizator/api/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/algoritmizator/api/update-email', [AuthController::class, 'updateEmail']);
    Route::post('/algoritmizator/api/update-avatar', [AuthController::class, 'updateAvatar']);
    Route::post('/algoritmizator/api/update-name', [AuthController::class, 'updateName']);
    Route::post('/algoritmizator/api/update-username', [AuthController::class, 'updateUsername']);
    Route::get('/algoritmizator/api/socials/search', [SearchController::class, 'search']);
    Route::get('/algoritmizator/api/socials/friends', [SearchController::class, 'getFriends']);
    Route::get('/algoritmizator/api/socials/friend-requests', [SearchController::class, 'getFriendRequests']);
    Route::post('/algoritmizator/api/socials/send-friend-request', [FriendController::class, 'sendFriendRequest']);
    Route::post('/algoritmizator/api/socials/accept-friend-request', [FriendController::class, 'acceptFriendRequest']);
    Route::post('/algoritmizator/api/socials/reject-friend-request', [FriendController::class, 'rejectFriendRequest']);
    Route::post('/algoritmizator/api/socials/remove-friend', [FriendController::class, 'removeFriend']);
});

Route::middleware('guest')->group(function () {
    Route::post('/algoritmizator/api/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::post('/algoritmizator/api/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::post('/algoritmizator/api/login', [AuthController::class, 'login']);
    Route::post('/algoritmizator/api/register', [AuthController::class, 'register']);
});
