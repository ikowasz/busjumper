<?php

namespace App\Entity\Timetable;

use App\Repository\Timetable\LineStopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineStopRepository::class)]
#[Orm\UniqueConstraint(columns: ['line_direction_id', 'stop_id'])]
#[Orm\UniqueConstraint(columns: ['line_direction_id', 'stop_order'])]
class LineStop
{
    public const FIRST_STOP_ORDER = 0;

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
    #[ORM\OneToMany(targetEntity: LineArrival::class, mappedBy: 'lineStop', orphanRemoval: true)]
    private Collection $arrivals;

    #[ORM\Column]
    private ?int $stop_order = null;

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
            $arrival->setLineStop($this);
        }

        return $this;
    }

    public function removeArrival(LineArrival $arrival): static
    {
        if ($this->arrivals->removeElement($arrival)) {
            // set the owning side to null (unless already changed)
            if ($arrival->getLineStop() === $this) {
                $arrival->setLineStop(null);
            }
        }

        return $this;
    }

    public function getStopOrder(): ?int
    {
        return $this->stop_order;
    }

    public function setStopOrder(int $stop_order): static
    {
        $this->stop_order = $stop_order;

        return $this;
    }
}
