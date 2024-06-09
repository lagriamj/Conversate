<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        Log::info("email: " . $request->email);
        Log::info("password: " . $request->password);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                'message' => 'Invalid email or password',
                'errors' => [
                    'email' => ['Invalid credentials'],
                    'password' => ['Invalid credentials.'],
                ]
            ], 422);
        }

        $user = Auth::user();

        $token = $request->user()->createToken('token')->plainTextToken;

        return response(['message' => 'Logged in', 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'Logged out'], 200);
    }
}