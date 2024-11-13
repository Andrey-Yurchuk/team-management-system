<?php

namespace App\Entity;

use App\Validator\Constraints as CustomAssert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[UniqueEntity(fields: ['email'], message: 'This email is already in use.')]
class Developer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $fullName;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    private string $position;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank]
    private string $contactNumber;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull]
    private \DateTimeInterface $hireDate;

    #[ORM\Column(type: 'boolean')]
    private bool $isActive;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $terminationDate = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull]
    #[CustomAssert\ValidBirthDate]
    private \DateTimeInterface $birthDate;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'developers')]
    #[ORM\JoinTable(name: 'developers_projects')]
    #[Assert\Count(min: 1, minMessage: 'Developer must be assigned to at least one project')]
    private Collection $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->isActive = true;
        $this->hireDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContactNumber(): string
    {
        return $this->contactNumber;
    }

    public function setContactNumber(string $contactNumber): self
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        $this->projects->removeElement($project);

        return $this;
    }

    public function getHireDate(): \DateTimeInterface
    {
        return $this->hireDate;
    }

    public function setHireDate(\DateTimeInterface $hireDate): self
    {
        $this->hireDate = $hireDate;
        return $this;
    }

    public function getTerminationDate(): ?\DateTimeInterface
    {
        return $this->terminationDate;
    }

    public function setTerminationDate(?\DateTimeInterface $terminationDate): self
    {
        $this->terminationDate = $terminationDate;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function calculateAge(): int
    {
        return (int) ((new \DateTime())->diff($this->birthDate)->y);
    }
}
