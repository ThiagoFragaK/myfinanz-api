<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function login(string $email, string $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'errors' => 'Invalid credentials',
                'http' => 401
            ];
        }

        $token = $user->createToken('auth_token', ['*'], now()->addMinutes(30))->plainTextToken;
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'is_first_login' => $user->is_first_login,
                'language' => $user->language,
                'currency' => $user->currency,
            ]
        ];

    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();
        return ['success' => true];
    }
}
