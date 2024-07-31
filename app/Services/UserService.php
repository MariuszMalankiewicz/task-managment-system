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
}