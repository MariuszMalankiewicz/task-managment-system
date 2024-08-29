<?php

namespace App\Http\Controllers\API;

use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTaskRequest;
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
}
