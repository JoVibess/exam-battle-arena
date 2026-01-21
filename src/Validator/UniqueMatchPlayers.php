<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class UniqueMatchPlayers extends Constraint
{
    public string $message = 'Ces deux joueurs se sont déjà affrontés.';

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
