<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

/**
 * Routes for unit tests.
 *
 * These routes are used specifically for unit testing purposes.
 */

/**
 * Route to get the authenticated user.
 */
Route::get('algoritmizator/api/user', static function () {
    return response()->json(auth()->user());
})->middleware('web');

/**
 * Route to verify email.
 *
 * @param  EmailVerificationRequest  $request
 * @return \Illuminate\Http\RedirectResponse
 */
Route::get('algoritmizator/auth/email/verify/{id}/{hash}', static function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('algoritmizator/auth/email-confirmed');
})->middleware(['auth', 'signed', 'web'])->name('verification.verify');

/**
 * Group of routes for authenticated users.
 */
Route::middleware(['auth', 'web'])->group(function () {
    /**
     * Route to send email verification notification.
     */
    Route::post('algoritmizator/api/email-verification-notification', [AuthController::class, 'emailVerificationNotification'])->middleware('throttle:6,1')->name('verification.send');
});

/**
 * Group of routes for authenticated and verified users.
 */
Route::middleware(['auth', 'verified', 'web'])->group(function () {
    /**
     * Route to update password.
     */
    Route::post('algoritmizator/api/update-password', [AuthController::class, 'updatePassword']);
    /**
     * Route to update email.
     */
    Route::post('algoritmizator/api/update-email', [AuthController::class, 'updateEmail']);
    /**
     * Route to update avatar.
     */
    Route::post('algoritmizator/api/update-avatar', [AuthController::class, 'updateAvatar']);
    /**
     * Route to update name.
     */
    Route::post('algoritmizator/api/update-name', [AuthController::class, 'updateName']);
    /**
     * Route to update username.
     */
    Route::post('algoritmizator/api/update-username', [AuthController::class, 'updateUsername']);
    /**
     * Route to search socials.
     */
    Route::get('algoritmizator/api/socials/search', [SearchController::class, 'search']);
    /**
     * Route to get friends.
     */
    Route::get('algoritmizator/api/socials/friends', [SearchController::class, 'getFriends']);
    /**
     * Route to get online friends.
     */
    Route::get('algoritmizator/api/socials/online-friends', [SearchController::class, 'getOnlineFriends']);
    /**
     * Route to get friend requests.
     */
    Route::get('algoritmizator/api/socials/friend-requests', [SearchController::class, 'getFriendRequests']);
    /**
     * Route to get user by ID.
     */
    Route::get('algoritmizator/api/users/{id}', [SearchController::class, 'getUser']);
    /**
     * Route to send a friend request.
     */
    Route::post('algoritmizator/api/socials/send-friend-request', [FriendController::class, 'sendFriendRequest']);
    /**
     * Route to accept a friend request.
     */
    Route::post('algoritmizator/api/socials/accept-friend-request', [FriendController::class, 'acceptFriendRequest']);
    /**
     * Route to reject a friend request.
     */
    Route::post('algoritmizator/api/socials/reject-friend-request', [FriendController::class, 'rejectFriendRequest']);
    /**
     * Route to remove a friend.
     */
    Route::post('algoritmizator/api/socials/remove-friend', [FriendController::class, 'removeFriend']);
    /**
     * Route to get lessons.
     */
    Route::get('algoritmizator/api/lessons', [LessonsController::class, 'getLessons']);
    /**
     * Route to get assignment and tasks by ID.
     */
    Route::get('algoritmizator/api/task/{id}', [LessonsController::class, 'getAssignmentAndTasks']);
    /**
     * Route to submit an assignment.
     */
    Route::post('algoritmizator/api/task/submit', [LessonsController::class, 'submitAssignment']);
    /**
     * Route to get all attempts.
     */
    Route::get('algoritmizator/api/task/attempts', [LessonsController::class, 'getAllAttempts']);
    /**
     * Route to get an attempt by ID.
     */
    Route::get('algoritmizator/api/task/attempt/{id}', [LessonsController::class, 'getAttempt']);
    /**
     * Route to get successful attempts by user ID.
     */
    Route::get('algoritmizator/api/task/attempts/successful/user/{id}', [LessonsController::class, 'getSuccessfulAttempts']);
    /**
     * Route to get the lesson of the hour.
     */
    Route::get('algoritmizator/api/lesson-of-the-hour', [LessonsController::class, 'getHourlyLesson']);
});

/**
 * Group of routes for guests.
 */
Route::middleware(['guest', 'web'])->group(function () {
    /**
     * Route to reset password.
     */
    Route::post('algoritmizator/api/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    /**
     * Route to send forgot password email.
     */
    Route::post('algoritmizator/api/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    /**
     * Route to login.
     */
    Route::post('algoritmizator/api/login', [AuthController::class, 'login']);
    /**
     * Route to register.
     */
    Route::post('algoritmizator/api/register', [AuthController::class, 'register']);
});
