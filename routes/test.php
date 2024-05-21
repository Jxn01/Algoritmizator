<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('algoritmizator/api/user', static function () {
    return response()->json(auth()->user());
})->middleware('web');

// Route for verifying the user's email address
Route::get('algoritmizator/auth/email/verify/{id}/{hash}', static function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('algoritmizator/auth/email-confirmed');
})->middleware(['auth', 'signed', 'web'])->name('verification.verify');

// Routes that require the user to be authenticated
Route::middleware(['auth', 'web'])->group(function () {
    // Routes for the application's authentication actions
    Route::post('algoritmizator/api/email-verification-notification', [AuthController::class, 'emailVerificationNotification'])->middleware('throttle:6,1')->name('verification.send');
});

// Routes that require the user to be authenticated
Route::middleware(['auth', 'verified', 'web'])->group(function () {
    // Routes for the application's user profile actions
    Route::post('algoritmizator/api/update-password', [AuthController::class, 'updatePassword']);
    Route::post('algoritmizator/api/update-email', [AuthController::class, 'updateEmail']);
    Route::post('algoritmizator/api/update-avatar', [AuthController::class, 'updateAvatar']);
    Route::post('algoritmizator/api/update-name', [AuthController::class, 'updateName']);
    Route::post('algoritmizator/api/update-username', [AuthController::class, 'updateUsername']);
    // Routes for the application's social features
    Route::get('algoritmizator/api/socials/search', [SearchController::class, 'search']);
    Route::get('algoritmizator/api/socials/friends', [SearchController::class, 'getFriends']);
    Route::get('algoritmizator/api/socials/online-friends', [SearchController::class, 'getOnlineFriends']);
    Route::get('algoritmizator/api/socials/friend-requests', [SearchController::class, 'getFriendRequests']);
    Route::get('algoritmizator/api/users/{id}', [SearchController::class, 'getUser']);
    Route::post('algoritmizator/api/socials/send-friend-request', [FriendController::class, 'sendFriendRequest']);
    Route::post('algoritmizator/api/socials/accept-friend-request', [FriendController::class, 'acceptFriendRequest']);
    Route::post('algoritmizator/api/socials/reject-friend-request', [FriendController::class, 'rejectFriendRequest']);
    Route::post('algoritmizator/api/socials/remove-friend', [FriendController::class, 'removeFriend']);

    // Routes for the application's lesson actions
    Route::get('algoritmizator/api/lessons', [LessonsController::class, 'getLessons']);
    Route::get('algoritmizator/api/task/{id}', [LessonsController::class, 'getAssignmentAndTasks']);
    Route::post('algoritmizator/api/task/submit', [LessonsController::class, 'submitAssignment']);
    Route::get('algoritmizator/api/task/attempts', [LessonsController::class, 'getAllAttempts']);
    Route::get('algoritmizator/api/task/attempt/{id}', [LessonsController::class, 'getAttempt']);
    Route::get('algoritmizator/api/task/attempts/successful/user/{id}', [LessonsController::class, 'getSuccessfulAttempts']);
    Route::get('algoritmizator/api/algorithm-of-the-hour', [LessonsController::class, 'getHourlyAlgorithm']);
});

// Routes that require the user to be a guest
Route::middleware(['guest', 'web'])->group(function () {
    // Routes for the application's authentication actions
    Route::post('algoritmizator/api/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::post('algoritmizator/api/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::post('algoritmizator/api/login', [AuthController::class, 'login']);
    Route::post('algoritmizator/api/register', [AuthController::class, 'register']);
});
