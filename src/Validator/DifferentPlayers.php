<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class DifferentPlayers extends Constraint
{
    public string $message = 'Les deux joueurs doivent être différents.';

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}