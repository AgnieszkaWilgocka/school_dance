<?php

namespace App\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;

class TagService implements TagServiceInterface
{
    private TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function findOneByTitle(string $title): ?Tag
    {
        return $this->tagRepository->findOneByTitle($title);
    }

    public function save(Tag $tag): void
    {
        $this->tagRepository->save($tag);
    }

    public function delete(Tag $tag): void
    {
        $this->tagRepository->delete($tag);
    }
}
