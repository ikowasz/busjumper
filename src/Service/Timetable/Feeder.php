<?php

namespace App\Service\Timetable;

use App\DTO\Loader\Arrival;
use App\Entity\Timetable\LineArrival;
use App\Service\Timetable\Feeder\Cache;
use Doctrine\ORM\EntityManagerInterface;

class Feeder
{
    private array $arrivalEntitiesBatch = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Cache $feederCache,
    )
    {}

    public function feedArrival(Arrival $arrival): LineArrival
    {
        $lineStop = $this->feederCache->getLineStop(
            lineNumber: $arrival->stop->direction->line->number,
            directionName: $arrival->stop->direction->name,
            stopName: $arrival->stop->name,
        );

        $arrivalEntity = new LineArrival;
        $arrivalEntity->setLineStop($lineStop);
        $arrivalEntity->setHour($arrival->hour);
        $arrivalEntity->setMinute($arrival->minute);

        $this->arrivalEntitiesBatch[] = $arrivalEntity;

        return $arrivalEntity;
    }

    public function flush(): void
    {
        if (count($this->arrivalEntitiesBatch) <= 0) {
            return;
        }

        foreach ($this->arrivalEntitiesBatch as $arrivalEntity) {
            $this->entityManager->persist($arrivalEntity);
        }

        $this->entityManager->flush();
        $this->arrivalEntitiesBatch = [];
    }
}