<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueProjectNameForClient extends Constraint
{
    public string $message = 'This project name is already in use for the client "{{ client }}".';
}
