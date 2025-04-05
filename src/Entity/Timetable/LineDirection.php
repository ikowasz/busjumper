<?php

namespace App\Entity\Timetable;

use App\Repository\Timetable\LineDirectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineDirectionRepository::class)]
#[ORM\Table(name: 'timetable_line_direction')]
#[Orm\UniqueConstraint(columns: ['line_id', 'direction_name'])]
class LineDirection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'lineDirections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Line $line = null;

    #[ORM\Column(length: 255)]
    private ?string $directionName = null;

    /**
     * @var Collection<int, LineStop>
     */
    #[ORM\OneToMany(targetEntity: LineStop::class, mappedBy: 'lineDirection', orphanRemoval: true)]
    private Collection $lineStops;

    public function __construct()
    {
        $this->lineStops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLine(): ?Line
    {
        return $this->line;
    }

    public function setLine(?Line $line): static
    {
        $this->line = $line;

        return $this;
    }

    public function getDirectionName(): ?string
    {
        return $this->directionName;
    }

    public function setDirectionName(string $directionName): static
    {
        $this->directionName = $directionName;

        return $this;
    }

    /**
     * @return Collection<int, LineStop>
     */
    public function getLineStops(): Collection
    {
        return $this->lineStops;
    }

    public function addLineStop(LineStop $lineStop): static
    {
        if (!$this->lineStops->contains($lineStop)) {
            $this->lineStops->add($lineStop);
            $lineStop->setLineDirection($this);
        }

        return $this;
    }

    public function removeLineStop(LineStop $lineStop): static
    {
        if ($this->lineStops->removeElement($lineStop)) {
            // set the owning side to null (unless already changed)
            if ($lineStop->getLineDirection() === $this) {
                $lineStop->setLineDirection(null);
            }
        }

        return $this;
    }
}
