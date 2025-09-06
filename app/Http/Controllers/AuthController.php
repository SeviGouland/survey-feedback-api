<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responder;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:responder,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $responder = Responder::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = JWTAuth::fromUser($responder);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

}
