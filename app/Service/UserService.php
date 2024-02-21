<?php

namespace App\Service;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

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

    public function storeRegularUser(array $data, User $master)
    {
        if ( $master->type != "master" ) {
            abort(401);
        }

        $data['type'] = 'regular';
        $data['master_id'] = $master->id;

        return $this->userRepository->store($data);
    }

    public function update(array $data, string $id ,User $master)
    {
        $this->find($id, $master);
        
        return $this->userRepository->update($id, $data);
    }

    public function find(string $id, User $master)
    {
        if ($master->type !== 'master') {
            abort(401);
        }

        $user = $this->userRepository->find($id);
        
        if (!$user || (!$master->regularUsers->contains($user) && $master->id != $id)) {
            abort(404);
        }

        return $user;
    }

    public function destroy(string $id)
    {
        $master = Auth::user();

        $this->find($id, $master);

        $this->userRepository->delete($id);

        return 'User deleted!';
    }
}
