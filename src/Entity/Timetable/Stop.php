<?php

namespace App\Entity\Timetable;

use App\Repository\Timetable\StopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StopRepository::class)]
#[ORM\Table(name: 'timetable_stop')]
class Stop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, LineStop>
     */
    #[ORM\OneToMany(targetEntity: LineStop::class, mappedBy: 'stop', orphanRemoval: true)]
    private Collection $lineStops;

    public function __construct()
    {
        $this->lineStops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $lineStop->setStop($this);
        }

        return $this;
    }

    public function removeLineStop(LineStop $lineStop): static
    {
        if ($this->lineStops->removeElement($lineStop)) {
            // set the owning side to null (unless already changed)
            if ($lineStop->getStop() === $this) {
                $lineStop->setStop(null);
            }
        }

        return $this;
    }
}
