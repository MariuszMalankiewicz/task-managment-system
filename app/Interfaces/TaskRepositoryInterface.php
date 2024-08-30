<?php

namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function createTask(array $data): Task;

    public function getTasksFromUserId(int $id): Collection;

    public function find(int $id): Task|null;

    public function update(Task $task, array $data): bool;

    public function delete(Task $task): bool;
}