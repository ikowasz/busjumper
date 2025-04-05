<?php

namespace App\Service\Timetable;

use App\DTO\Loader\Line;
use App\DTO\Loader\Stop;
use Psr\Log\LoggerInterface;

class Puller
{
    private ?Loader $loader = null;

    public function __construct(
        private readonly ArrivalsCleaner $arrivalsCleaner,
        private readonly Feeder $feeder,
        private readonly LoggerInterface $logger,
    )
    {}

    public function setLoader(Loader $loader): self
    {
        $this->loader = $loader;

        return $this;
    }

    public function getLoader(): Loader
    {
        if (!isset($this->loader)) {
            throw new \LogicException('Loader is not set');
        }

        return $this->loader;
    }


    public function pull(): array
    {
        $this->logger->info('Pulling timetable');

        $loader = $this->getLoader();
        $lines = $loader->getLines();
        $entities = [];
        foreach ($lines as $line) {
            $batch = $this->pullLine($line);
            $entities = array_merge($entities, $batch);
        }

        return $entities;
    }

    public function pullLine(Line $line): array
    {
        $this->logger->info('Pulling line ' . $line->number);

        $loader = $this->getLoader();
        $directedStops = $loader->getLineStops($line);
        $entities = [];
        foreach ($directedStops as $directedStop) {
            foreach ($directedStop->stops as $stop) {
                $batch = $this->pullStop($stop);
                $entities = array_merge($entities, $batch);
            }
        }

        return $entities;
    }

    public function pullStop(Stop $stop): array 
    {
        $this->logger->info('Pulling stop ' . $stop->name . ' of line ' . $stop->direction->line->number . ' in direction ' . $stop->direction->name);

        $this->arrivalsCleaner->clear(
            lineNumber: $stop->direction->line->number,
            directionName: $stop->direction->name,
            stopName: $stop->name,
        );

        $loader = $this->getLoader();
        $arrivals = $loader->getStopArrivals($stop);
        $entities = [];

        foreach ($arrivals as $arrival) {
            $entities[] = $this->feeder->feedArrival($arrival);
        }

        $this->feeder->flush();
        $this->logger->info('Arrivals for stop ' . $stop->name . ': ' . join(', ', array_map(fn ($entity) => $entity->getHour() . ':' . $entity->getMinute(), $entities)));

        return $entities;
    }
}