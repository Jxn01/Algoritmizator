<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
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
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);

        $user = new User([
            'id' => $this->generateUUID(),
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 1,
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
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Successfully logged out!',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function emailVerificationNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();

        $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('avatars', $avatarName);

        $user->avatar = $avatarName;
        $user->save();

        return response()->json([
            'message' => 'Successfully updated avatar!',
            'avatar' => $avatarName,
        ]);
    }

    public function updatePassword(Request $request)
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

    public function updateName(Request $request)
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

    public function updateUsername(Request $request)
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

    public function updateEmail(Request $request)
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

    private function generateUUID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0x0FFF) | 0x4000,
            mt_rand(0, 0x3FFF) | 0x8000,
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF)
        );
    }
}
