<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Class AuthController
 *
 * The AuthController handles authentication related actions such as login, registration, password reset, and more.
 */
class AuthController extends Controller
{
    /**
     * Handle user login.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = (bool) $request->remember;

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $request->user()->update([
                'is_online' => true,
                'last_online' => Carbon::now(),
            ]);
            $request->user()->save();

            return response()->json([
                'message' => 'Successfully logged in!',
            ])->withCookie('XRSF-TOKEN', csrf_token());
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    /**
     * Handle user registration.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'total_xp' => 0,
            'is_online' => true,
            'last_online' => Carbon::now(),
        ]);

        $user->save();

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $request->user()->save();

            event(new Registered($user));

            return response()->json([
                'message' => 'Successfully registered and logged in!',
            ])->withCookie('XRSF-TOKEN', csrf_token());
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    /**
     * Handle password reset.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            static function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'message' => __($status),
            ])
            : response()->json([
                'message' => __($status),
            ], 400);
    }

    /**
     * Handle password reset link request.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if(User::where('email', $request->email)->doesntExist()) {
            return response()->json([
                'message' => 'User does not exist',
            ], 404);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json([
                'message' => __($status),
            ])
            : response()->json([
                'message' => __($status),
            ], 400);
    }

    /**
     * Send email verification notification.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function emailVerificationNotification(Request $request): RedirectResponse
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    /**
     * Handle avatar update.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function updateAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();
        $oldAvatar = $user->avatar;

        $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('public/avatars', $avatarName);

        $user->avatar = $avatarName;
        $user->save();

        if ($oldAvatar !== 'default.png') {
            //unlink from storage/app/public/avatars
            unlink(storage_path('app/public/avatars/'.$oldAvatar));
        }

        return response()->json([
            'message' => 'Successfully updated avatar!',
            'avatar' => $avatarName,
        ]);
    }

    /**
     * Handle password update.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'oldPassword' => 'required|string',
            'password' => 'required|min:8|string',
        ]);

        $user = $request->user();

        if (! Hash::check($request->oldPassword, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect',
            ], 400);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Successfully updated password!',
        ]);
    }

    /**
     * Handle name update.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function updateName(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $user = $request->user();

        $user->name = $request->name;
        $user->save();

        return response()->json([
            'message' => 'Successfully updated name!',
        ]);
    }

    /**
     * Handle username update.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function updateUsername(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $user = $request->user();

        $existingUser = User::where('username', $request->username)->first();
        if ($existingUser) {
            return response()->json([
                'message' => 'Username is already taken',
            ], 400);
        }

        $user->username = $request->username;
        $user->save();

        return response()->json([
            'message' => 'Successfully updated username!',
        ]);
    }

    /**
     * Handle email update.
     *
     * @param  Request  $request  The incoming HTTP request.
     */
    public function updateEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password is incorrect',
            ], 401);
        }

        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json([
                'message' => 'E-mail is already taken',
            ], 400);
        }

        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => 'Successfully updated e-mail!',
        ]);
    }
}
