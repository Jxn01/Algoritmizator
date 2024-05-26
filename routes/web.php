<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

/**
 * Group of routes with Inertia middleware.
 */
Route::middleware('inertia')->group(function () {

    /**
     * Group of routes for authenticated, snoop, and verified users.
     */
    Route::middleware(['auth', 'snoop', 'verified'])->group(function () {
        /**
         * Route to show the user profile.
         */
        Route::get('/app/profile', [PageController::class, 'showProfile'])->name('profile');

        /**
         * Route to show social connections.
         */
        Route::get('/app/socials', [PageController::class, 'showSocials'])->name('socials');

        /**
         * Route to show a specific user's profile.
         *
         * @param  int  $id
         */
        Route::get('/app/socials/profile/{id}', [PageController::class, 'showUserProfile'])->middleware('redirectFromOwnProfile')->name('user-profile');

        /**
         * Route to show a specific task.
         *
         * @param  int  $id
         */
        Route::get('/lessons/task/{id}', [PageController::class, 'showTask'])->name('task');

        /**
         * Route to show a specific task attempt.
         *
         * @param  int  $id
         */
        Route::get('/lessons/task/attempt/{id}', [PageController::class, 'showTaskAttempt'])->name('task-attempt');

        /**
         * Route to show email confirmed page.
         */
        Route::get('/auth/email-confirmed', [PageController::class, 'showEmailConfirmed']);

        /**
         * Route to show lessons.
         */
        Route::get('/app/lessons', [PageController::class, 'showLessons'])->name('lessons');

        /**
         * Route to show the dashboard (root).
         */
        Route::get('/', [PageController::class, 'showDashboard'])->name('dashboard1');

        /**
         * Route to show the dashboard (/app).
         */
        Route::get('/app', [PageController::class, 'showDashboard'])->name('dashboard2');
    });

    /**
     * Group of routes for authenticated and snoop users.
     */
    Route::middleware(['auth', 'snoop'])->group(function () {
        /**
         * Route to show the logout page.
         */
        Route::get('/auth/logout', [PageController::class, 'showLogout'])->middleware('logout');

        /**
         * Route to show email confirmation notice.
         */
        Route::get('/auth/confirm-email', [PageController::class, 'showConfirmEmail'])->name('verification.notice');
    });

    /**
     * Group of routes for guest users.
     */
    Route::middleware('guest')->group(function () {
        /**
         * Route to show login page.
         */
        Route::get('/auth/login', [PageController::class, 'showLogin'])->name('login');

        /**
         * Route to show registration page.
         */
        Route::get('/auth/registration', [PageController::class, 'showRegistration']);

        /**
         * Route to show forgot password page.
         */
        Route::get('/auth/forgot-password', [PageController::class, 'showForgotPassword'])->name('password.request');

        /**
         * Route to show reset password page.
         *
         * @param  string  $token
         */
        Route::get('/auth/reset-password/{token}', [PageController::class, 'showResetPassword'])->name('password.reset');
    });

    /**
     * Route to show error page.
     *
     * @param  string  $type
     */
    Route::get('/error/{type}', [PageController::class, 'showError']);

    /**
     * Fallback route for undefined routes.
     */
    Route::fallback([PageController::class, 'showNotFound']);
});

/**
 * Route to get the authenticated user.
 */
Route::get('/api/user', static function () {
    return response()->json(auth()->user());
});

/**
 * Route to verify email.
 *
 * @param  EmailVerificationRequest  $request
 * @return \Illuminate\Http\RedirectResponse
 */
Route::get('/auth/email/verify/{id}/{hash}', static function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/auth/email-confirmed');
})->middleware(['auth', 'signed'])->name('verification.verify');

/**
 * Group of routes for authenticated users.
 */
Route::middleware('auth')->group(function () {
    /**
     * Route to send email verification notification.
     */
    Route::post('/api/email-verification-notification', [AuthController::class, 'emailVerificationNotification'])->middleware('throttle:6,1')->name('verification.send');
});

/**
 * Group of routes for authenticated and verified users.
 */
Route::middleware(['auth', 'verified'])->group(function () {
    /**
     * Route to update password.
     */
    Route::post('/api/update-password', [AuthController::class, 'updatePassword']);

    /**
     * Route to update email.
     */
    Route::post('/api/update-email', [AuthController::class, 'updateEmail']);

    /**
     * Route to update avatar.
     */
    Route::post('/api/update-avatar', [AuthController::class, 'updateAvatar']);

    /**
     * Route to update name.
     */
    Route::post('/api/update-name', [AuthController::class, 'updateName']);

    /**
     * Route to update username.
     */
    Route::post('/api/update-username', [AuthController::class, 'updateUsername']);

    /**
     * Route to search socials.
     */
    Route::get('/api/socials/search', [SearchController::class, 'search']);

    /**
     * Route to get friends.
     */
    Route::get('/api/socials/friends', [SearchController::class, 'getFriends']);

    /**
     * Route to get online friends.
     */
    Route::get('/api/socials/online-friends', [SearchController::class, 'getOnlineFriends']);

    /**
     * Route to get friend requests.
     */
    Route::get('/api/socials/friend-requests', [SearchController::class, 'getFriendRequests']);

    /**
     * Route to get user by ID.
     *
     * @param  int  $id
     */
    Route::get('/api/users/{id}', [SearchController::class, 'getUser']);

    /**
     * Route to send a friend request.
     */
    Route::post('/api/socials/send-friend-request', [FriendController::class, 'sendFriendRequest']);

    /**
     * Route to accept a friend request.
     */
    Route::post('/api/socials/accept-friend-request', [FriendController::class, 'acceptFriendRequest']);

    /**
     * Route to reject a friend request.
     */
    Route::post('/api/socials/reject-friend-request', [FriendController::class, 'rejectFriendRequest']);

    /**
     * Route to remove a friend.
     */
    Route::post('/api/socials/remove-friend', [FriendController::class, 'removeFriend']);

    /**
     * Route to get lessons.
     */
    Route::get('/api/lessons', [LessonsController::class, 'getLessons']);

    /**
     * Route to get assignment and tasks by ID.
     *
     * @param  int  $id
     */
    Route::get('/api/task/{id}', [LessonsController::class, 'getAssignmentAndTasks']);

    /**
     * Route to submit an assignment.
     */
    Route::post('/api/task/submit', [LessonsController::class, 'submitAssignment']);

    /**
     * Route to get all attempts.
     */
    Route::get('/api/task/attempts', [LessonsController::class, 'getAllAttempts']);

    /**
     * Route to get an attempt by ID.
     *
     * @param  int  $id
     */
    Route::get('/api/task/attempt/{id}', [LessonsController::class, 'getAttempt']);

    /**
     * Route to get successful attempts by user ID.
     *
     * @param  int  $id
     */
    Route::get('/api/task/attempts/successful/user/{id}', [LessonsController::class, 'getSuccessfulAttempts']);

    /**
     * Route to get the lesson of the hour.
     */
    Route::get('/api/lesson-of-the-hour', [LessonsController::class, 'getHourlyLesson']);
});

/**
 * Group of routes for guest users.
 */
Route::middleware('guest')->group(function () {
    /**
     * Route to reset password.
     */
    Route::post('/api/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    /**
     * Route to send forgot password email.
     */
    Route::post('/api/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

    /**
     * Route to login.
     */
    Route::post('/api/login', [AuthController::class, 'login']);

    /**
     * Route to register.
     */
    Route::post('/api/register', [AuthController::class, 'register']);
});
