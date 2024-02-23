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
    
        // Consulta inicial para obter todas as tarefas
        $tasksQuery = $this->obj->query();
    
        // Aplicar filtro por usuário, se for um usuário regular
        if ($user->role !== 'master') {
            $tasksQuery->where('user_id', $user->id);
        }
    
        // Aplicar filtro por id, se fornecido
        if (isset($filters['id'])) {
            $tasksQuery->where('id', $filters['id']);
        }
    
        // Aplicar filtro por título, se fornecido
        if (isset($filters['title'])) {
            $tasksQuery->where('title', 'like', '%' . $filters['title'] . '%');
        }
    
        // Aplicar filtro por status, se fornecido
        if (isset($filters['status'])) {
            $tasksQuery->where('status', $filters['status']);
        }
    
        // Retornar as tarefas paginadas de acordo com a consulta construída
        return $tasksQuery->paginate($perPage);
    }
}
