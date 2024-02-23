<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(protected User $user)
    {
        parent::__construct($user);
    }

    public function all(): object
    {
        return $this->obj
        ->join('users as master', 'users.master_id', '=', 'master.id')
        ->select('users.*', 'master.name as master_name')
        ->get();
    }
}
