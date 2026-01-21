<?php

namespace App\Repository;

use App\Entity\MatchResult;
use App\Entity\GameMatch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MatchResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchResult::class);
    }

    /**
     * Vérifie si un joueur a déjà saisi un résultat pour un match donné.
     */
    public function findOneByMatchAndPlayer(GameMatch $match, User $player): ?MatchResult
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.match = :match')
            ->andWhere('r.player = :player')
            ->setParameter('match', $match)
            ->setParameter('player', $player)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Récupère tous les résultats associés à un match.
     */
    public function findByMatch(GameMatch $match): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.match = :match')
            ->setParameter('match', $match)
            ->getQuery()
            ->getResult();
    }
}
