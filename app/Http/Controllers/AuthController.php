<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{
    /**
     * @throws BindingResolutionException
     */
    public function login(ServerRequestInterface $request)
    {
        //append grant_type to the request
        $request = $request->withParsedBody($request->getParsedBody() + [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
            'scope' => '*',
        ]);

        $tokenController = app()->make(AccessTokenController::class);

        return $tokenController->issueToken($request);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'confirmPassword' => 'required|string|same:password',
        ]);

        $user = new User([
            'id' => $this->generateUUID(),
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 1,
            'total_xp' => 0,
            'is_online' => false,
            'last_online' => Carbon::now(),
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!',
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
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

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
