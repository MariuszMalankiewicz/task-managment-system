<?php

namespace App\Services;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(protected UserRepository $userRepository){}
    public function createUser(array $data): User
    {
        return $this->userRepository->createUser($data);
    } 

    public function findUserFromEmail(string $email): User|null
    {
        return $this->userRepository->findUserFromEmail($email);
    } 

    public function findUserFromId(int $id): User|null
    {
        return $this->userRepository->findUserFromId($id);
    }
}