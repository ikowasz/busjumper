<?php

namespace App\Repository\Timetable;

use App\Entity\Timetable\LineArrival;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LineArrival>
 */
class LineArrivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineArrival::class);
    }

    public function findByLineDirectionAndStop(
        string $lineNumber,
        string $directionName,
        string $stopName,
    ): array
    {
        return $this->createQueryBuilder('la')
            ->innerJoin('la.lineStop', 'ls')
            ->innerJoin('ls.direction', 'ld')
            ->innerJoin('ls.stop', 's')
            ->andWhere('ld.line = :lineNumber')
            ->andWhere('ld.directionName = :directionName')
            ->andWhere('s.name = :stopName')
            ->setParameter('lineNumber', $lineNumber)
            ->setParameter('directionName', $directionName)
            ->setParameter('stopName', $stopName)
            ->getQuery()
            ->getResult();
    }

    public function findExactOne(
        string $lineNumber,
        string $directionName,
        string $stopName,
        int $hour,
        int $minute,
    ): ?LineArrival
    {
        return $this->createQueryBuilder('la')
            ->innerJoin('la.lineStop', 'ls')
            ->innerJoin('ls.direction', 'ld')
            ->innerJoin('ls.stop', 's')
            ->andWhere('ld.line = :lineNumber')
            ->andWhere('ld.directionName = :directionName')
            ->andWhere('s.name = :stopName')
            ->andWhere('la.hour = :hour')
            ->andWhere('la.minute = :minute')
            ->setParameter('lineNumber', $lineNumber)
            ->setParameter('directionName', $directionName)
            ->setParameter('stopName', $stopName)
            ->setParameter('hour', $hour)
            ->setParameter('minute', $minute)
            ->getQuery()
            ->getOneOrNullResult();

    }

    //    /**
    //     * @return LineArrival[] Returns an array of LineArrival objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LineArrival
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
