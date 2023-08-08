<?php

namespace App\Entity;

use App\Repository\MyClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MyClassesRepository::class)]
class MyClasses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Dance $dance = null;

    #[ORM\ManyToOne]
    private ?User $author = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDance(): ?Dance
    {
        return $this->dance;
    }

    public function setDance(?Dance $dance): void
    {
        $this->dance = $dance;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

}
