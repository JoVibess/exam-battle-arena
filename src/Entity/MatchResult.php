<?php

namespace App\Entity;

use App\Repository\MatchResultRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MatchResultRepository::class)]
#[UniqueEntity(
    fields: ['gameMatch', 'player'],
    message: 'Ce joueur a déjà saisi un résultat pour ce match.'
)]
class MatchResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le match est obligatoire.')]
    private ?GameMatch $gameMatch = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le joueur est obligatoire.')]
    private ?User $player = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotNull]
    #[Assert\Choice(
        choices: ['WIN', 'LOSS'],
        message: 'Le résultat doit être WIN ou LOSS.'
    )]
    private ?string $result = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameMatch(): ?GameMatch
    {
        return $this->gameMatch;
    }

    public function setGameMatch(GameMatch $gameMatch): static
    {
        $this->gameMatch = $gameMatch;
        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(User $player): static
    {
        $this->player = $player;
        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): static
    {
        $this->result = $result;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
