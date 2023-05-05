<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use App\Service\TagServiceInterface;
use Symfony\Component\Form\DataTransformerInterface;

class TagsDataTransformer implements DataTransformerInterface
{
    private TagServiceInterface $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Transform array of tags to string od tag titles
     *
     * @param $value
     *
     * @return string
     */
    public function transform($value): string
    {
        if ($value->isEmpty()) {
            return ' ';
        }

        $tagTitles = [];

        foreach($value as $tag) {
            $tagTitles[] = $tag->getTitle();
        }

        return implode(', ', $tagTitles);
    }

    /**
     * Transform string of tag names into array of Tag entities
     *
     * @param $value
     *
     * @return array
     */
    public function reverseTransform($value): array
    {
        $tagTitles = explode(',', $value);
        $tags = [];

        foreach($tagTitles as $tagTitle) {
            $tagTitle = trim($tagTitle);
            if('' !== $tagTitle) {
                $tag = $this->tagService->findOneByTitle(strtolower($tagTitle));
                if(null === $tag) {
                    $tag = new Tag();
                    $tag->setTitle($tagTitle);
                    $tag->setCreatedAt(new \DateTimeImmutable());
                    $tag->setUpdatedAt(new \DateTimeImmutable());

                    $this->tagService->save($tag);
                }

                $tags[] = $tag;
            }
        }

        return $tags;
    }
}