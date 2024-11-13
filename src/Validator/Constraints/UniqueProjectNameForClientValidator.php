<?php

namespace App\Validator\Constraints;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


class UniqueProjectNameForClientValidator extends ConstraintValidator
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueProjectNameForClient) {
            throw new UnexpectedTypeException($constraint, UniqueProjectNameForClient::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $project = $this->context->getObject();
        $client = $project->getClient();
        $name = $project->getName();

        $existingProject = $this->entityManager->getRepository(Project::class)
            ->findOneBy(['client' => $client, 'name' => $name]);

        if ($existingProject && $existingProject !== $project) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ client }}', $client)
                ->addViolation();
        }
    }
}
