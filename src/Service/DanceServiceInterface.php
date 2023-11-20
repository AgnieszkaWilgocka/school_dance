<?php

namespace App\Service;

use App\Entity\Dance;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface DanceServiceInterface
{
    public function getPaginatedList(int $page): PaginationInterface;
    public function save(Dance $dance): void;

    public function delete(Dance $dance): void;

    public function canBeDeleted(Dance $dance): bool;
}