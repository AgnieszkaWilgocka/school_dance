<?php

namespace App\Service;

use App\Entity\Dance;

interface DanceServiceInterface
{
    public function save(Dance $dance): void;

    public function delete(Dance $dance): void;
}