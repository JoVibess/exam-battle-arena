<?php

namespace App\Validator;

use App\Entity\GameMatch;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DifferentPlayersValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof GameMatch) {
            return;
        }

        if ($value->getPlayerOne() && $value->getPlayerTwo() && $value->getPlayerOne() === $value->getPlayerTwo()) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath('playerTwo')
                ->addViolation();
        }
    }
}
