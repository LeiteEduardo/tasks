<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Service\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        return $this->taskService->all($request);
    }

    public function store(StoreTaskRequest $request)
    {
        return $this->taskService->store($request->validated(), $request->user());
    }

    public function show(string $id)
    {
        return $this->taskService->find($id);
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        return $this->taskService->update($request->validated(), $id, $request->user());
    }

    public function destroy(string $id)
    {
        return $this->taskService->destroy($id);
    }

    public function findByColumn(string $column, $value)
    {
        return $this->taskService->findByColumn($column, $value);
    }
}
