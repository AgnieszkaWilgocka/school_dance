<?php

namespace App\Service;

use App\Entity\Dance;
use App\Repository\DanceRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Knp\Component\Pager\Event\PaginationEvent;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class DanceService implements DanceServiceInterface
{
    private DanceRepository $danceRepository;

    private PaginatorInterface $paginator;

    private TagServiceInterface $tagService;


    public function __construct(DanceRepository $danceRepository, PaginatorInterface $paginator, TagServiceInterface $tagService)
    {
        $this->danceRepository = $danceRepository;
        $this->paginator = $paginator;
        $this->tagService = $tagService;
    }

    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->danceRepository->queryAll($filters),
            $page,
            DanceRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function save(Dance $dance): void
    {
        $this->danceRepository->save($dance);
    }

    public function delete(Dance $dance): void
    {
        $this->danceRepository->delete($dance);
    }

    public function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if(!empty($filters['tag_id'])) {
            $tag = $this->tagService->findOneById($filters['tag_id']);
            if(null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        return $resultFilters;
    }
}
