<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'device_id' => 'required|string|min:6',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $user->createToken($request->device_id)->plainTextToken,
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'device_id' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));


        return response()->json([
            'message' => 'Register successful',
            'access_token' => $user->createToken($request->device_id)->plainTextToken,
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);


        $status = Password::sendResetLink($request->only('email'));


        if ($status != Password::RESET_LINK_SENT) {
            return response()->json([
                'email' => [__($status)],
            ]);
        }

        return response()->json([
            'status' => __($status),
        ]);
    }
}
