<?php

namespace App\Entity;

use App\Repository\DanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DanceRepository::class)]
#[ORM\Table(name: 'dances')]
class Dance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $field = null;

    /**
     * @var ArrayCollection<int Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class)]
    #[ORM\JoinTable(name: 'dances_tags')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Getter for id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for name
     *
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for field
     *
     * @return int|null
     */
    public function getField(): ?int
    {
        return $this->field;
    }

    /**
     * Setter for field
     *
     * @param int $field
     *
     * @return void
     */
    public function setField(int $field): void
    {
        $this->field = $field;
    }

    /**
     * Getter for tags
     *
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     *
     * @return void
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     *
     * @return void
     */
    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }
}
