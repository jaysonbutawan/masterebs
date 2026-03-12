<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return [
                'status' => false,
                'message' => 'User not found'
            ];
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return [
                'status' => false,
                'message' => 'Invalid password'
            ];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'status' => true,
            'token' => $token,
            'user' => $user
        ];
    }

    public function getProfile($id)
    {
        return User::find($id);
    }
}