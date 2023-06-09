<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
    }
}