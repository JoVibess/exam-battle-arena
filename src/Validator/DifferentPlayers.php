<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class DifferentPlayers extends Constraint
{
    public string $message = 'Un joueur ne peut pas s’affronter lui-même.';
}
