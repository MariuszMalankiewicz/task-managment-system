<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService){}
    public function store(StoreTaskRequest $storeTaskRequest): JsonResponse
    {
        $validatedData = $storeTaskRequest->validated();

        $task = $this->taskService->createTask($validatedData);

        return response()->json(['message' => 'zadanie stworzone', 'data' => $task], Response::HTTP_CREATED);
    }

    public function index()
    {
        $userId = Auth::check();

        $tasks = $this->taskService->getTasksFromUserId($userId);

        return response()->json(['data' => $tasks], Response::HTTP_OK);
    }

    public function update(UpdateTaskRequest $updateTaskRequest, int $id)
    {
        $validatedData = $updateTaskRequest->validated();

        $task = $this->taskService->updateTask($id, $validatedData);

        if(!$task)
        {
            return response()->json(['message' => 'nie znaleziono zadania', 'data' => null], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'zadanie zaktualizowane', 'data' => $task], Response::HTTP_OK);
    }
    
    public function destroy(int $id): JsonResponse
    {
        $taskDeleted = $this->taskService->deleteTask($id);

        if(!$taskDeleted)
        {
            return response()->json(['message' => 'nie znaleziono zadania'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
