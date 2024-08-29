<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function createTask(array $data): Task
    {
        $task = new Task();

        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->status = $data['status'];
        $task->user_id = $data['user_id'];

        $task->save();

        return $task;
    }
}