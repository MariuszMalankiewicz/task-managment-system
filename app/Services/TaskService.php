<?php

namespace App\Services;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(protected TaskRepository $taskRepository){}

    public function createTask(array $data)
    {
        return $this->taskRepository->createTask($data);
    }
}