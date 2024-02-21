<?php

namespace App\Service;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    public function store(array $data)
    {
        return $this->userRepository->store($data);
    }

    public function storeRegularUser(array $data, User $user)
    {
        if ( $user->type != "master" ) {
            throw ValidationException::withMessages(['error' => 'Unauthorized']);
        }

        $data['type'] = 'regular';
        $data['master_id'] = $user->id;

        return $this->userRepository->store($data);
    }
}
