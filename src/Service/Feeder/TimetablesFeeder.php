<?php

namespace App\Service\Feeder;

use App\DTO\Loader\Arrival;
use App\Entity\Timetable\LineArrival;
use App\Entity\Timetable\LineStop;
use App\Repository\Timetable\LineArrivalRepository;
use App\Service\Retriever\Timetable\LineStopRetriever;
use Doctrine\ORM\EntityManagerInterface;

class TimetablesFeeder
{
    public function __construct(
        private readonly LineStopRetriever $lineStopRetriever,
        private readonly LineArrivalRepository $lineArrivalRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function feedArrival(Arrival $arrival): LineArrival
    {
        $lineStop = $this->lineStopRetriever->get(
            lineNumber: $arrival->stop->direction->line->number,
            directionName: $arrival->stop->direction->name,
            stopName: $arrival->stop->name,
        );

        $arrivalEntity = new LineArrival;
        $arrivalEntity->setStop($lineStop);
        $arrivalEntity->setHour($arrival->hour);
        $arrivalEntity->setMinute($arrival->minute);

        $this->entityManager->persist($arrivalEntity);
        $this->entityManager->flush();

        return $arrivalEntity;
    }
}