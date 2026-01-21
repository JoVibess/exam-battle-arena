<?php

namespace App\Entity;

use App\Repository\GameMatchRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\DifferentPlayers;
use App\Validator\UniqueMatchPlayers;

#[ORM\Entity(repositoryClass: GameMatchRepository::class)]
#[DifferentPlayers]
#[UniqueMatchPlayers]
class GameMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le joueur 1 est obligatoire.')]
    private ?User $playerOne = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le joueur 2 est obligatoire.')]
    private ?User $playerTwo = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive(message: 'Le round doit être un nombre positif.')]
    private ?int $round = null;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(
        choices: ['scheduled', 'validated', 'conflict'],
        message: 'Statut de match invalide.'
    )]
    private ?string $status = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->status = 'scheduled';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerOne(): ?User
    {
        return $this->playerOne;
    }

    public function setPlayerOne(User $playerOne): static
    {
        $this->playerOne = $playerOne;
        return $this;
    }

    public function getPlayerTwo(): ?User
    {
        return $this->playerTwo;
    }

    public function setPlayerTwo(User $playerTwo): static
    {
        $this->playerTwo = $playerTwo;
        return $this;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(int $round): static
    {
        $this->round = $round;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
