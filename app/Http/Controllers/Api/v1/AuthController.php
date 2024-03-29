<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\v1\AuthResource;
use App\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->only('email', 'password'));
    }

    public function register(RegisterRequest $request)
    {
        return new AuthResource( $this->authService->register($request->validated()) );
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    public function myUser()
    {
        return new AuthResource( $this->authService->myUser() );
    }
}
