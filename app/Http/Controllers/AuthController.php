<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(SignupRequest $request): JsonResponse|RedirectResponse
    {
        $user = $this->authService->register(
            $request->validated()
        );

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(
            $request->validated()
        );

        if (!$result['status']) {
            return response()->json([
                'message' => $result['message']
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $result['token'],
            'user' => $result['user']
        ]);
    }
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $this->authService->logout($user);

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    public function profile($id)
    {
        $user = $this->authService->getProfile($id);

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
