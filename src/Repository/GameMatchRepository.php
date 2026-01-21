<?php

namespace App\Repository;

use App\Entity\GameMatch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameMatch>
 */
class GameMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameMatch::class);
    }

    /**
     * Retourne un match existant entre deux joueurs (quel que soit l'ordre),
     * en excluant éventuellement un match (utile en édition).
     */
    public function findExistingMatch(User $p1, User $p2, ?int $excludeId = null): ?GameMatch
    {
        $qb = $this->createQueryBuilder('m')
            ->where('(m.playerOne = :p1 AND m.playerTwo = :p2)')
            ->orWhere('(m.playerOne = :p2 AND m.playerTwo = :p1)')
            ->setParameter('p1', $p1)
            ->setParameter('p2', $p2);

        if ($excludeId !== null) {
            $qb->andWhere('m.id != :id')
               ->setParameter('id', $excludeId);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }
}
