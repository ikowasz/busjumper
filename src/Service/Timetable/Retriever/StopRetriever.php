<?php

namespace App\Service\Timetable\Retriever;

use App\Entity\Timetable\Stop;
use App\Repository\Timetable\StopRepository;
use Doctrine\ORM\EntityManagerInterface;

class StopRetriever
{
    public function __construct(
        private readonly StopRepository $stopRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function get(string $name): Stop
    {
        $stop = $this->find($name);

        if ($stop !== null) {
            return $stop;
        }

        return $this->create($name);
    }

    private function find(string $name): ?Stop
    {
        return $this->stopRepository->findOneByName($name);
    }

    public function create(string $name): Stop
    {
        $stop = new Stop();
        $stop->setName($name);
        $this->entityManager->persist($stop);
        $this->entityManager->flush();

        return $stop;
    }
}