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
            return response()->json([
                'message'   => 'Authorized',
                'token'     => [ 'type' => 'Bearer', 'token' => Auth::user()->createToken('token')->plainTextToken ]
            ], 200);
        }

        return response()->json([
            'message'   => 'Unauthorized'
        ], 401);
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
