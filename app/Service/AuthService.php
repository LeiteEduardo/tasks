<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $user->createToken('token')->plainTextToken;
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function register(array $data)
    {
        return User::create($data);
    }
}
