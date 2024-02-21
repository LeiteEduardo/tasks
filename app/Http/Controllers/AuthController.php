<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Service\AuthService;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->only('email', 'password'));

        return response()->json($user);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return response()->json($user);
    }

    public function myUser()
    {
        $user = $this->authService->myUser();

        return response()->json($user);
    }
}
