<?php

namespace App\Entity;

use App\Repository\UserrDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserrDataRepository::class)]
#[ORM\Table(name: 'users_data')]
class UserData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nick = null;

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
     * Getter for nick
     *
     * @return string|null
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Setter for nick
     *
     * @param string|null $nick
     *
     * @return void
     */
    public function setNick(?string $nick): void
    {
        $this->nick = $nick;
    }
}
