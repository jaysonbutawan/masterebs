<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\SignupRequest;
use App\Http\Request\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(SignupRequest $request):JsonResponse|RedirectResponse
    {

        $validated = $request->validate();

        $user = User::create($validated);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);

    }
    public function login(LoginRequest $request)
    {
        $validated = $request->validate();

        $user = User::where('email', $validated->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ]);
    }

    public function profile($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User profile retrieved successfully',
            'user' => $user
        ]);
    }

    public function health()
    {
        return response()->json([
            'message' => 'API is up and running'
        ]);
    }
}
