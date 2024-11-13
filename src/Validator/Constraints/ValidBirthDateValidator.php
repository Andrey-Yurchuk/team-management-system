<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidBirthDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidBirthDate) {
            throw new UnexpectedTypeException($constraint, ValidBirthDate::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof \DateTime) {
            throw new UnexpectedValueException($value, 'DateTime');
        }

        $now = new \DateTime();
        $minAgeDate = (new \DateTime())->modify('-18 years');

        if ($value > $now) {
            $this->context->buildViolation($constraint->futureMessage)
            ->setParameter('{{ value }}', $value->format('Y-m-d'))
                ->addViolation();
            return;
        }

        if ($value > $minAgeDate) {
            $this->context->buildViolation($constraint->underageMessage)
            ->setParameter('{{ value }}', $value->format('Y-m-d'))
                ->addViolation();
        }
    }
}
