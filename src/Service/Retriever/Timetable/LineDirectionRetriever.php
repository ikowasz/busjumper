<?php

namespace App\Service\Retriever\Timetable;

use App\Entity\Timetable\LineDirection;
use App\Repository\Timetable\LineDirectionRepository;
use App\Service\Retriever\Timetable\LineRetriever;
use Doctrine\ORM\EntityManagerInterface;

class LineDirectionRetriever
{
    public function __construct(
        private readonly LineRetriever $lineRetriever,
        private readonly LineDirectionRepository $lineDirectionRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function get(string $lineNumber, string $directionName): LineDirection
    {
        $lineDirection = $this->lineDirectionRepository->findOneByLineAndDirectionName(
            lineNumber: $lineNumber,
            directionName: $directionName,
        );

        if ($lineDirection !== null) {
            return $lineDirection;
        }

        return $this->create(
            lineNumber: $lineNumber,
            directionName: $directionName,
        );
    }

    public function create(string $lineNumber, string $directionName): LineDirection
    {
        $line = $this->lineRetriever->get($lineNumber);

        $lineDirection = new LineDirection();
        $lineDirection->setLine($line);
        $lineDirection->setDirectionName($directionName);

        $this->entityManager->persist($lineDirection);
        $this->entityManager->flush();

        return $lineDirection;
    }
}