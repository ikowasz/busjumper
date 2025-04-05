<?php

namespace App\Service\Timetable\Retriever;

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
        $lineStop = $this->find(
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

    public function find(string $lineNumber, string $directionName, string $stopName): ?LineStop
    {
        return $this->lineStopRepository->findOneByLineDirectionAndStop(
            lineNumber: $lineNumber,
            directionName: $directionName,
            stopName: $stopName,
        );
    }

    public function create(string $lineNumber, string $directionName, string $stopName): LineStop
    {
        $lineDirection = $this->lineDirectionRetriever->get($lineNumber, $directionName);
        $lastLineStop = $this->lineStopRepository->findLastByLineAndDirection($lineNumber, $directionName);
        $stop = $this->stopRetriever->get($stopName);

        $lineStop = new LineStop();
        $lineStop->setLineDirection($lineDirection);
        $lineStop->setStop($stop);
        $lineStop->setStopOrder($lastLineStop ? $lastLineStop->getStopOrder() + 1 : LineStop::FIRST_STOP_ORDER);

        $this->entityManager->persist($lineStop);
        $this->entityManager->flush();

        return $lineStop;

    }
}