<?php

namespace App\Http\Controllers\API;

use App\Services\TaskService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\JsonResponse;
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
}
