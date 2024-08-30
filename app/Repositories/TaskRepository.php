<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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

    public function getTasksFromUserId(int $id): Collection
    {
        return Task::where('user_id', $id)->get();
    }

    public function find(int $id): Task|null
    {
        return Task::find($id);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }
}