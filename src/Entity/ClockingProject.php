<?php

namespace App\Entity;

use App\Repository\ClockingProjectRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClockingProjectRepository::class)]
class ClockingProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'project')]
    private ?Clocking $clocking = null;

    #[ORM\ManyToOne(inversedBy: 'clockingProjects')]
    private ?Project $project = null;

    #[Assert\Positive]
    #[Assert\LessThanOrEqual(value: 10)]
    #[ORM\Column(type: Types::INTEGER)]
    private ?float $duration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClocking(): ?Clocking
    {
        return $this->clocking;
    }

    public function setClocking(?Clocking $clocking): static
    {
        $this->clocking = $clocking;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(?float $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function __toString()
    {
        return $this->getProject()->getName();
    }
}
