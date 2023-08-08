<?php

namespace App\Service;

use App\Entity\MyClasses;
use App\Entity\User;
use App\Repository\MyClassesRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class MyClassesService
{
    private MyClassesRepository $myClassesRepository;

    private PaginatorInterface $paginator;
    public function __construct(MyClassesRepository $myClassesRepository, PaginatorInterface $paginator)
    {
     $this->myClassesRepository = $myClassesRepository;
     $this->paginator = $paginator;
    }

    public function getPaginatedList(int $page, User $author): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->myClassesRepository->queryByAuthor($author),
            $page,
            MyClassesRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function delete(MyClasses $myClasses): void
    {
        $this->myClassesRepository->delete($myClasses);
    }
}