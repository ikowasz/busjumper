<?php

namespace App\Entity\Timetable;

use App\Repository\Timetable\LineStopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineStopRepository::class)]
#[Orm\UniqueConstraint(columns: ['line_direction_id', 'stop_id'])]
class LineStop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'directionStops')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LineDirection $lineDirection = null;

    #[ORM\ManyToOne(inversedBy: 'lineStops')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stop $stop = null;

    /**
     * @var Collection<int, LineArrival>
     */
    #[ORM\OneToMany(targetEntity: LineArrival::class, mappedBy: 'stop', orphanRemoval: true)]
    private Collection $arrivals;

    public function __construct()
    {
        $this->arrivals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLine(): ?Line
    {
        return $this->lineDirection?->getLine();
    }

    public function getLineDirection(): ?LineDirection
    {
        return $this->lineDirection;
    }

    public function setLineDirection(?LineDirection $direction): static
    {
        $this->lineDirection = $direction;

        return $this;
    }

    public function getStop(): ?Stop
    {
        return $this->stop;
    }

    public function setStop(?Stop $stop): static
    {
        $this->stop = $stop;

        return $this;
    }

    /**
     * @return Collection<int, LineArrival>
     */
    public function getArrivals(): Collection
    {
        return $this->arrivals;
    }

    public function addArrival(LineArrival $arrival): static
    {
        if (!$this->arrivals->contains($arrival)) {
            $this->arrivals->add($arrival);
            $arrival->setStop($this);
        }

        return $this;
    }

    public function removeArrival(LineArrival $arrival): static
    {
        if ($this->arrivals->removeElement($arrival)) {
            // set the owning side to null (unless already changed)
            if ($arrival->getStop() === $this) {
                $arrival->setStop(null);
            }
        }

        return $this;
    }
}
