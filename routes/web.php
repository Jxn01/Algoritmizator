<?php

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
    Route::middleware(['auth', 'snoop', 'verified'])->group(function () {
        // Routes for the application's main pages
        Route::get('/app/profile', [PageController::class, 'showProfile'])->name('profile');
        Route::get('/app/socials', [PageController::class, 'showSocials'])->name('socials');
        Route::get('/app/socials/profile/{id}', [PageController::class, 'showUserProfile'])->middleware('redirectFromOwnProfile')->name('user-profile');
        Route::get('/lessons/task/{id}', [PageController::class, 'showTask'])->name('task');
        Route::get('/lessons/task/attempt/{id}', [PageController::class, 'showTaskAttempt'])->name('task-attempt');
        Route::get('/auth/email-confirmed', [PageController::class, 'showEmailConfirmed']);
        Route::get('/app/lessons', [PageController::class, 'showLessons'])->name('lessons');
        Route::get('/', [PageController::class, 'showDashboard'])->name('dashboard1');
        Route::get('/app', [PageController::class, 'showDashboard'])->name('dashboard2');
    });

    // Routes that require the user to be authenticated
    Route::middleware(['auth', 'snoop'])->group(function () {
        // Routes for the application's authentication pages
        Route::get('/auth/logout', [PageController::class, 'showLogout'])->middleware('logout');
        Route::get('/auth/confirm-email', [PageController::class, 'showConfirmEmail'])->name('verification.notice');
    });

    // Routes that require the user to be a guest
    Route::middleware('guest')->group(function () {
        // Routes for the application's authentication pages
        Route::get('/auth/login', [PageController::class, 'showLogin'])->name('login');
        Route::get('/auth/registration', [PageController::class, 'showRegistration']);
        Route::get('/auth/forgot-password', [PageController::class, 'showForgotPassword'])->name('password.request');
        Route::get('/auth/reset-password/{token}', [PageController::class, 'showResetPassword'])->name('password.reset');
    });

    Route::get('/error/{type}', [PageController::class, 'showError']);

    // Fallback route for when no other route matches
    Route::fallback([PageController::class, 'showNotFound']);
});

Route::get('/api/user', static function () {
    return response()->json(auth()->user());
});

// Route for verifying the user's email address
Route::get('/auth/email/verify/{id}/{hash}', static function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/auth/email-confirmed');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Routes that require the user to be authenticated
Route::middleware('auth')->group(function () {
    // Routes for the application's authentication actions
    Route::post('/api/email-verification-notification', [AuthController::class, 'emailVerificationNotification'])->middleware('throttle:6,1')->name('verification.send');
});

// Routes that require the user to be authenticated
Route::middleware(['auth', 'verified'])->group(function () {
    // Routes for the application's user profile actions
    Route::post('/api/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/api/update-email', [AuthController::class, 'updateEmail']);
    Route::post('/api/update-avatar', [AuthController::class, 'updateAvatar']);
    Route::post('/api/update-name', [AuthController::class, 'updateName']);
    Route::post('/api/update-username', [AuthController::class, 'updateUsername']);
    // Routes for the application's social features
    Route::get('/api/socials/search', [SearchController::class, 'search']);
    Route::get('/api/socials/friends', [SearchController::class, 'getFriends']);
    Route::get('/api/socials/online-friends', [SearchController::class, 'getOnlineFriends']);
    Route::get('/api/socials/friend-requests', [SearchController::class, 'getFriendRequests']);
    Route::get('/api/users/{id}', [SearchController::class, 'getUser']);
    Route::post('/api/socials/send-friend-request', [FriendController::class, 'sendFriendRequest']);
    Route::post('/api/socials/accept-friend-request', [FriendController::class, 'acceptFriendRequest']);
    Route::post('/api/socials/reject-friend-request', [FriendController::class, 'rejectFriendRequest']);
    Route::post('/api/socials/remove-friend', [FriendController::class, 'removeFriend']);

    // Routes for the application's lesson actions
    Route::get('/api/lessons', [LessonsController::class, 'getLessons']);
    Route::get('/api/task/{id}', [LessonsController::class, 'getAssignmentAndTasks']);
    Route::post('/api/task/submit', [LessonsController::class, 'submitAssignment']);
    Route::get('/api/task/attempts', [LessonsController::class, 'getAllAttempts']);
    Route::get('/api/task/attempt/{id}', [LessonsController::class, 'getAttempt']);
    Route::get('/api/task/attempts/successful/user/{id}', [LessonsController::class, 'getSuccessfulAttempts']);
    Route::get('/api/lesson-of-the-hour', [LessonsController::class, 'getHourlyLesson']);
});

// Routes that require the user to be a guest
Route::middleware('guest')->group(function () {
    // Routes for the application's authentication actions
    Route::post('/api/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::post('/api/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::post('/api/login', [AuthController::class, 'login']);
    Route::post('/api/register', [AuthController::class, 'register']);
});
