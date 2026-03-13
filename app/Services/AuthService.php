<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data)
    {
        $customerRole = Role::where('name', 'customer')->firstOrFail();

        return User::create([
            'role_id' => $customerRole->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    public function login(array $credentials)
    {
        $user = User::with('role.permissions')
            ->where('email', $credentials['email'])
            ->first();

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

     public function logout($user)
    {
        $user->currentAccessToken()->delete();
    }

    public function getProfile($id)
    {
        return User::with('role.permissions')->find($id);
    }
}