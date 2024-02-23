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

    public function paginate(int $perPage = 10, array $filters = []): object
    {
        $user = Auth::user();
    
        $tasksQuery = $this->obj->query();
    
        if ($user->role !== 'master') {
            $tasksQuery->where('user_id', $user->id);
        }
    
        if (isset($filters['id'])) {
            $tasksQuery->where('id', $filters['id']);
        }
    
        if (isset($filters['title'])) {
            $tasksQuery->where('title', 'like', '%' . $filters['title'] . '%');
        }
    
        if (isset($filters['status'])) {
            $tasksQuery->where('status', $filters['status']);
        }
    
        return $tasksQuery
            ->join('users', 'tasks.responsible_id', '=', 'users.id')
            ->select('tasks.*', 'users.name as responsible')
            ->paginate($perPage);
    }
}
