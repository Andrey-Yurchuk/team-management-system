<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidBirthDate extends Constraint
{
    public string $futureMessage = 'The birthdate cannot be in the future.';
    public string $underageMessage = 'The person must be at least 18 years old.';
}


