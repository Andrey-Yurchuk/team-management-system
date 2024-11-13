<?php

namespace App\Entity;

use App\Validator\Constraints\UniqueProjectNameForClient;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[UniqueProjectNameForClient]
    private string $name;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $client;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull]
    private \DateTimeInterface $startDate;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isActive;

    #[ORM\ManyToMany(targetEntity: Developer::class, mappedBy: 'projects')]
    private Collection $developers;

    public function __construct()
    {
        $this->developers = new ArrayCollection();
        $this->isActive = true;
        $this->startDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getClient(): string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getDevelopers(): Collection
    {
        return $this->developers;
    }

    public function addDeveloper(Developer $developer): self
    {
        if (!$this->developers->contains($developer)) {
            $this->developers->add($developer);
            $developer->addProject($this);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): self
    {
        if ($this->developers->removeElement($developer)) {
            $developer->removeProject($this);
        }

        return $this;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
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
}
