<?php

namespace App\Service;

use App\Entity\User;

interface UserServiceInterface
{
    public function save(User $user): void;

    public function delete(User $user): void;
}
