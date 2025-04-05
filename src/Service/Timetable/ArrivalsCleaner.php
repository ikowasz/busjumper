<?php

namespace App\Service\Timetable;

use App\Repository\Timetable\LineArrivalRepository;
use App\Service\Timetable\Retriever\LineStopRetriever;
use Doctrine\ORM\EntityManagerInterface;

class ArrivalsCleaner
{
    public function __construct(
        private readonly LineStopRetriever $lineStopRetriever,
        private readonly LineArrivalRepository $lineArrivalRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function clear(string $lineNumber, string $directionName, string $stopName): void
    {
        $lineStop = $this->lineStopRetriever->find(
            lineNumber: $lineNumber,
            directionName: $directionName,
            stopName: $stopName,
        );

        if ($lineStop === null) {
            return;
        }

        foreach ($lineStop->getArrivals() as $arrival) {
            $this->entityManager->remove($arrival);
        }

        $this->entityManager->flush();
    }

}