<?php

namespace App\Service;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(protected UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return ['access_token' => $token, 'token_type' => 'Bearer'];
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function register(array $data)
    {
        $user = $this->userRepository->store($data);
        $token = $user->createToken('token')->plainTextToken;

        return ['user' => $user, 'access_token' => $token, 'token_type' => 'Bearer'];
    }

    public function myUser()
    {
        $user = $this->userRepository->find(Auth::user()->id);
        $token = $user->createToken('token')->plainTextToken;

        return ['user' => $user, 'access_token' => $token, 'token_type' => 'Bearer'];
    }
}
