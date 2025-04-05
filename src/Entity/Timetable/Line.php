<?php

namespace App\Entity\Timetable;

use App\Repository\Timetable\LineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineRepository::class)]
#[ORM\Table(name: 'timetable_line')]
class Line
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $number = null;

    /**
     * @var Collection<int, LineDirection>
     */
    #[ORM\OneToMany(targetEntity: LineDirection::class, mappedBy: 'line', orphanRemoval: true)]
    private Collection $lineDirections;

    public function __construct()
    {
        $this->lineDirections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, LineDirection>
     */
    public function getLineDirections(): Collection
    {
        return $this->lineDirections;
    }

    public function addLineDirection(LineDirection $lineDirection): static
    {
        if (!$this->lineDirections->contains($lineDirection)) {
            $this->lineDirections->add($lineDirection);
            $lineDirection->setLine($this);
        }

        return $this;
    }

    public function removeLineDirection(LineDirection $lineDirection): static
    {
        if ($this->lineDirections->removeElement($lineDirection)) {
            // set the owning side to null (unless already changed)
            if ($lineDirection->getLine() === $this) {
                $lineDirection->setLine(null);
            }
        }

        return $this;
    }
}
