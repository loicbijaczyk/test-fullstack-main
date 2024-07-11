<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\ClockingRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClockingRepository::class)]
class Clocking
{

    #[ORM\ManyToOne(targetEntity:User::class, inversedBy: 'clockings', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User              $clockingUser;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $date            = null;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int               $id              = null;

    #[ORM\OneToMany(targetEntity: ClockingProject::class, mappedBy: 'clocking', cascade: ['persist'])]
    private Collection $clockingProjects;

    public function __construct()
    {
        $this->clockingProjects = new ArrayCollection();
    }

    public function getDate() : ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date) : void
    {
        $this->date = $date;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getClockingUser() : ?User
    {
        return $this->clockingUser;
    }

    public function setClockingUser(?User $clockingUser) : static
    {
        $this->clockingUser = $clockingUser;

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
            $clockingProject->setClocking($this);
        }

        return $this;
    }

    public function removeClockingProject(ClockingProject $clockingProject): static
    {
        if ($this->clockingProjects->removeElement($clockingProject)) {
            // set the owning side to null (unless already changed)
            if ($clockingProject->getClocking() === $this) {
                $clockingProject->setClocking(null);
            }
        }

        return $this;
    }
   
}
