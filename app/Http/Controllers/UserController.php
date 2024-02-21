<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Service\UserService;
use Illuminate\Support\Facades\Auth;

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
        $user = $this->userService->storeRegularUser($request->validated(), $request->user());

        return response()->json($user);
    }

    public function show(string $id)
    {
        $user = $this->userService->find($id, Auth::user());

        return response()->json($user);
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        $user = $this->userService->update($request->validated(), $id, $request->user());

        return response()->json($user);
    }

    public function destroy(string $id)
    {
        $user = $this->userService->destroy($id);

        return response()->json($user);
    }
}
