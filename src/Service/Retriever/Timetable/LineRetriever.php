<?php

namespace App\Service\Retriever\Timetable;

use App\Entity\Timetable\Line;
use App\Repository\Timetable\LineRepository;
use Doctrine\ORM\EntityManagerInterface;

class LineRetriever
{
    public function __construct(
        private readonly LineRepository $lineRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function get(string $number): Line
    {
        $line = $this->lineRepository->findOneByNumber($number);

        if ($line !== null) {
            return $line;
        }

        return $this->create($number);
    }

    public function create(string $number): Line 
    {
        $line = new Line();
        $line->setNumber($number);
        
        $this->entityManager->persist($line);
        $this->entityManager->flush();

        return $line;
    }
}