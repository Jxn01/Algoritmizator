<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

/**
 * This file defines the routes for the web application.
 * It uses Laravel's routing system to map URLs to controller actions.
 * It also uses middleware to restrict access to certain routes based on the user's authentication status.
 */

// Routes that require the inertia middleware
Route::middleware('inertia')->group(function () {
    // Routes that require the user to be authenticated
    Route::middleware(['auth', 'snoop'])->group(function () {
        // Routes for the application's main pages
        Route::get('/algoritmizator/app/profile', [PageController::class, 'showProfile'])->name('profile');
        Route::get('/algoritmizator/app/socials', [PageController::class, 'showSocials'])->name('socials');
        Route::get('/algoritmizator/app/socials/{id}/profile', [PageController::class, 'showUserProfile'])->middleware('redirectFromOwnProfile')->name('user-profile');
        Route::get('/algoritmizator/app/lessons/{id}/quiz', [PageController::class, 'showQuiz'])->name('quiz');
        Route::get('/algoritmizator/app/lessons/{id}/quiz/result/{quizId}', [PageController::class, 'showQuizResult'])->name('quiz-result');
        Route::get('/algoritmizator/auth/email-confirmed', [PageController::class, 'showEmailConfirmed']);
        Route::get('/algoritmizator/app/lessons', [PageController::class, 'showLessons'])->name('lessons');
    });

    // Routes that require the user to be authenticated
    Route::middleware(['auth', 'snoop'])->group(function () {
        // Routes for the application's authentication pages
        Route::get('/algoritmizator/auth/logout', [PageController::class, 'showLogout'])->name('logout');
        Route::get('/algoritmizator/auth/confirm-email', [PageController::class, 'showConfirmEmail'])->name('verification.notice');
    });

    // Routes that require the user to be a guest
    Route::middleware('guest')->group(function () {
        // Routes for the application's authentication pages
        Route::get('/algoritmizator/auth/login', [PageController::class, 'showLogin'])->name('login');
        Route::get('/algoritmizator/auth/registration', [PageController::class, 'showRegistration']);
        Route::get('/algoritmizator/auth/forgot-password', [PageController::class, 'showForgotPassword'])->name('password.request');
        Route::get('/algoritmizator/auth/reset-password/{token}', [PageController::class, 'showResetPassword'])->name('password.reset');
    });

    // Routes for the application's main pages
    Route::get('/algoritmizator/', [PageController::class, 'showDashboard'])->middleware('snoop')->name('dashboard1');
    Route::get('/algoritmizator/app', [PageController::class, 'showDashboard'])->middleware('snoop')->name('dashboard2');
    Route::get('/algoritmizator/error/{type}', [PageController::class, 'showError']);

    // Fallback route for when no other route matches
    Route::fallback([PageController::class, 'showNotFound']);
});

// Route for verifying the user's email address
Route::get('/algoritmizator/auth/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/algoritmizator/auth/email-confirmed');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Routes that require the user to be authenticated
Route::middleware('auth')->group(function () {
    // Routes for the application's authentication actions
    Route::post('/algoritmizator/api/logout', [AuthController::class, 'logout']);
    Route::post('/algoritmizator/api/email-verification-notification', [AuthController::class, 'emailVerificationNotification'])->middleware('throttle:6,1')->name('verification.send');
});

// Routes that require the user to be authenticated
Route::middleware(['auth'])->group(function () {
    // Routes for the application's user profile actions
    Route::post('/algoritmizator/api/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/algoritmizator/api/update-email', [AuthController::class, 'updateEmail']);
    Route::post('/algoritmizator/api/update-avatar', [AuthController::class, 'updateAvatar']);
    Route::post('/algoritmizator/api/update-name', [AuthController::class, 'updateName']);
    Route::post('/algoritmizator/api/update-username', [AuthController::class, 'updateUsername']);
    // Routes for the application's social features
    Route::get('/algoritmizator/api/socials/search', [SearchController::class, 'search']);
    Route::get('/algoritmizator/api/socials/friends', [SearchController::class, 'getFriends']);
    Route::get('/algoritmizator/api/socials/friend-requests', [SearchController::class, 'getFriendRequests']);
    Route::post('/algoritmizator/api/socials/send-friend-request', [FriendController::class, 'sendFriendRequest']);
    Route::post('/algoritmizator/api/socials/accept-friend-request', [FriendController::class, 'acceptFriendRequest']);
    Route::post('/algoritmizator/api/socials/reject-friend-request', [FriendController::class, 'rejectFriendRequest']);
    Route::post('/algoritmizator/api/socials/remove-friend', [FriendController::class, 'removeFriend']);

    // Routes for the application's lesson actions
    Route::get('/algoritmizator/api/lessons', [LessonsController::class, 'getLessons']);
    Route::get('/algoritmizator/api/quiz/{id}', [LessonsController::class, 'getQuiz']);
    Route::post('/algoritmizator/api/quiz/{id}/submit', [LessonsController::class, 'submitQuiz']);
    Route::get('/algoritmizator/api/quiz/{id}/attempts', [LessonsController::class, 'getAttempts']);

    Route::post('/algoritmizator/api/update-activity', [ActivityController::class, 'updateActivity']);
});

// Routes that require the user to be a guest
Route::middleware('guest')->group(function () {
    // Routes for the application's authentication actions
    Route::post('/algoritmizator/api/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::post('/algoritmizator/api/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::post('/algoritmizator/api/login', [AuthController::class, 'login']);
    Route::post('/algoritmizator/api/register', [AuthController::class, 'register']);
});
