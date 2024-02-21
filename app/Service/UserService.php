<?php

namespace App\Service;

use App\Http\Resources\v1\UserResource;
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
        return UserResource::collection( $this->userRepository->all() );
    }

    public function store(array $data)
    {
        return new UserResource( $this->userRepository->store($data) );
    }

    public function storeRegularUser(array $data, User $master)
    {
        if ( $master->type != "master" ) {
            return response()->json([
                'message'   => 'Unauthorized'
            ], 401);
        }

        $data['type'] = 'regular';
        $data['master_id'] = $master->id;

        return new UserResource( $this->userRepository->store($data) ); 
    }

    public function update(array $data, string $id ,User $master)
    {
        $this->find($id, $master);
        
        return new UserResource( $this->userRepository->update($id, $data) );
    }

    public function find(string $id)
    {
        $master = Auth::user();

        if ($master->type !== 'master') {
            return response()->json([
                'message'   => 'Unauthorized'
            ], 401);
        }

        $user = $this->userRepository->find($id);
        
        if (!$user || (!$master->regularUsers->contains($user) && $master->id != $id)) {
            return response()->json([
                'message'   => 'Not Found'
            ], 404);
        }

        return new UserResource( $user );
    }

    public function destroy(string $id)
    {
        $master = Auth::user();

        $this->find($id, $master);

        $this->userRepository->delete($id);

        return response()->json([
            'message'   => 'User deleted!'
        ], 200);
    }
}
