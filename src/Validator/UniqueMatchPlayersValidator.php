<?php

namespace App\Validator;

use App\Entity\GameMatch;
use App\Repository\GameMatchRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueMatchPlayersValidator extends ConstraintValidator
{
    public function __construct(
        private readonly GameMatchRepository $repository
    ) {}

    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof GameMatch) {
            return;
        }

        $p1 = $value->getPlayerOne();
        $p2 = $value->getPlayerTwo();

        // Tant qu'on n'a pas les deux joueurs, on ne valide pas cette règle.
        if (!$p1 || !$p2) {
            return;
        }

        // Si tu édites un match existant, on exclut son id de la recherche.
        $excludeId = $value->getId();

        $existingMatch = $this->repository->findExistingMatch($p1, $p2, $excludeId);

        if ($existingMatch !== null) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath('playerTwo')
                ->addViolation();
        }
    }
}
