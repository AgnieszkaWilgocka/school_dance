<?php

namespace App\Service;

use App\Entity\MyClasses;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface MyClassesServiceInterface
{
    public function getPaginatedList(int $page, User $author): PaginationInterface;

    public function delete(MyClasses $myClasses): void;
}