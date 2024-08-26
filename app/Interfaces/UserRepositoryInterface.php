<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function createUser(array $data): User;

    public function findUserFromEmail(string $email): User|null;

    public function findUserFromId(int $id): User|null;
}