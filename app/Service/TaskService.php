<?php

namespace App\Service;

use App\Http\Resources\v1\TaskResource;
use App\Models\User;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function __construct(protected TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function all($request)
    {
        $filters = [
            'id' => $request->query('id'),
            'title' => $request->query('title'),
            'status' => $request->query('status')
        ];
        
        $tasks = $this->taskRepository->paginate(10, $filters);
    
        return TaskResource::collection( $tasks );
    }

    public function store(array $data, User $master)
    {
        if ( $master->type != "master" ) {
            return response()->json([
                'message'   => 'Unauthorized'
            ], 401);
        }

        $data['user_id'] = $master->id;

        return new TaskResource( $this->taskRepository->store($data) );
    }

    public function find(string $id)
    {
        $master = Auth::user();

        $task = $this->taskRepository->find($id);
        
        if ( !$task || $master->id != $task->user_id ) {
            return response()->json([
                'message'   => 'Not Found'
            ], 404);
        }

        return new TaskResource( $task );
    }

    public function update(array $data, string $id)
    {
        $this->find($id);
        
        return new TaskResource( $this->taskRepository->update($id, $data) );
    }

    public function destroy(string $id)
    {
        $master = Auth::user();

        $this->find($id, $master);

        $this->taskRepository->delete($id);

        return response()->json([
            'message'   => 'Task deleted!'
        ], 200);
    }

    public function findByColumn(string $column, $value)
    {
        return TaskResource::collection( $this->taskRepository->findByColumn($column, $value) );
    }
}
