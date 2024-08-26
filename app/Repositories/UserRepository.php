<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data): User
    {
        $user = new User();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        $user->save();

        return $user;
    }

    public function findUserFromEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    public function findUserFromId(int $id): User|null
    {
        return User::find($id)->first();
    }
}