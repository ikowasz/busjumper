<?php

namespace App\Service\Timetable\Retriever;

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
        $line = $this->find($number);

        if ($line !== null) {
            return $line;
        }

        return $this->create($number);
    }

    private function find(string $number): ?Line
    {
        return $this->lineRepository->findOneByNumber($number);
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