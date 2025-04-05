<?php

namespace App\Service\Retriever\Timetable;

use App\Entity\Timetable\LineStop;
use App\Repository\Timetable\LineStopRepository;
use Doctrine\ORM\EntityManagerInterface;

class LineStopRetriever
{
    public function __construct(
        private readonly LineStopRepository $lineStopRepository,
        private readonly StopRetriever $stopRetriever,
        private readonly LineDirectionRetriever $lineDirectionRetriever,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function get(string $lineNumber, string $directionName, string $stopName): LineStop
    {
        $lineStop = $this->lineStopRepository->findOneByLineDirectionAndStop(
            lineNumber: $lineNumber,
            directionName: $directionName,
            stopName: $stopName,
        );

        if ($lineStop !== null) {
            return $lineStop;
        }

        return $this->create(
            lineNumber: $lineNumber,
            directionName: $directionName,
            stopName: $stopName,
        );
    }

    public function create(string $lineNumber, string $directionName, string $stopName): LineStop
    {
        $lineDirection = $this->lineDirectionRetriever->get($lineNumber, $directionName);
        $stop = $this->stopRetriever->get($stopName);

        $lineStop = new LineStop();
        $lineStop->setLineDirection($lineDirection);
        $lineStop->setStop($stop);

        $this->entityManager->persist($lineStop);
        $this->entityManager->flush();

        return $lineStop;

    }
}