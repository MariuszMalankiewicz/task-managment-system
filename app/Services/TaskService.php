<?php

namespace App\Services;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(protected TaskRepository $taskRepository){}

    public function createTask(array $data): Task
    {
        return $this->taskRepository->createTask($data);
    }

    public function getTasksFromUserId(int $id): Collection
    {
        return $this->taskRepository->getTasksFromUserId($id);
    }

    public function updateTask(int $id, array $data): Task|bool
    {
        $task = $this->taskRepository->find($id);

        if(!$task)
        {
            return false;
        }

        $this->taskRepository->update($task, $data);

        return $task;
    }
}