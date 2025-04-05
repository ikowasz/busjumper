<?php

namespace App\Service\Timetable;

use App\Repository\Timetable\LineArrivalRepository;
use App\Repository\Timetable\LineStopRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArrivalsCleaner
{
    public function __construct(
        private readonly LineStopRepository $lineStopRepository,
        private readonly LineArrivalRepository $lineArrivalRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function clear(string $lineNumber, string $directionName, string $stopName): void
    {
        $lineStop = $this->lineStopRepository->findOneByLineDirectionAndStop(
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