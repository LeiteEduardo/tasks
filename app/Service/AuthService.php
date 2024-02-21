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
            return Auth::user();
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function register(array $data)
    {
        return $this->userRepository->store($data);
    }

    public function myUser()
    {
        return $this->userRepository->find(Auth::user()->id);
    }
}
