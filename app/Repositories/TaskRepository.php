<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository extends BaseRepository
{
    public function __construct(protected Task $task)
    {
        parent::__construct($task);
    }

    public function all(): object
    {
        return $this->obj->where('user_id', Auth::user()->id)->paginate(10);
    }
}
