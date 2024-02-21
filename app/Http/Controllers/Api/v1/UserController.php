<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Service\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->getAllUsers();
    }

    public function store(UserStoreRequest $request)
    {
        return $this->userService->storeRegularUser($request->validated(), $request->user());
    }

    public function show(string $id)
    {
        return $this->userService->find($id);
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        return $this->userService->update($request->validated(), $id, $request->user());
    }

    public function destroy(string $id)
    {
        return $this->userService->destroy($id);
    }
}
