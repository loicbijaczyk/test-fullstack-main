<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\ProjectRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{

    #[ORM\Column(length: 255)]
    private ?string            $address   = null;

    #[Assert\GreaterThan(propertyPath: 'dateStart')]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $dateEnd   = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $dateStart = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int               $id        = null;

    #[ORM\Column(length: 255)]
    private ?string            $name      = null;

    #[ORM\OneToMany(targetEntity: ClockingProject::class, mappedBy: 'project')]
    private Collection $clockingProjects;

    public function __construct()
    {
        $this->clockingProjects = new ArrayCollection();
    }

    public function getAddress() : ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address) : void
    {
        $this->address = $address;
    }

    public function getDateEnd() : ?DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?DateTimeInterface $dateEnd) : void
    {
        $this->dateEnd = $dateEnd;
    }

    public function getDateStart() : ?DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(?DateTimeInterface $dateStart) : void
    {
        $this->dateStart = $dateStart;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(string $name) : static
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return Collection<int, ClockingProject>
     */
    public function getClockingProject(): Collection
    {
        return $this->clockingProjects;
    }

    public function addClockingProject(ClockingProject $clockingProject): static
    {
        if (!$this->clockingProjects->contains($clockingProject)) {
            $this->clockingProjects->add($clockingProject);
            $clockingProject->setProject($this);
        }

        return $this;
    }

    public function removeClockingProject(ClockingProject $clockingProject): static
    {
        if ($this->clockingProjects->removeElement($clockingProject)) {
            // set the owning side to null (unless already changed)
            if ($clockingProject->getProject() === $this) {
                $clockingProject->setProject(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
    
}
