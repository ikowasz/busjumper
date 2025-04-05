<?php

namespace App\Entity\Timetable;

use App\Repository\Timetable\LineArrivalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineArrivalRepository::class)]
#[ORM\UniqueConstraint(columns: ['stop_id', 'hour', 'minute'])]
class LineArrival
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'arrivals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LineStop $stop = null;

    #[ORM\Column]
    private ?int $hour = null;

    #[ORM\Column]
    private ?int $minute = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStop(): ?LineStop
    {
        return $this->stop;
    }

    public function setStop(?LineStop $stop): static
    {
        $this->stop = $stop;

        return $this;
    }

    public function getHour(): ?int
    {
        return $this->hour;
    }

    public function setHour(int $hour): static
    {
        $this->hour = $hour;

        return $this;
    }

    public function getMinute(): ?int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): static
    {
        $this->minute = $minute;

        return $this;
    }
}
