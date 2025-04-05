<?php

namespace App\Repository\Timetable;

use App\Entity\Timetable\LineStop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LineStop>
 */
class LineStopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineStop::class);
    }

    public function findOneByLineDirectionAndStop(string $lineNumber, string $directionName, string $stopName): ?LineStop
    {
        return $this->createQueryBuilder('ls')
            ->innerJoin('ls.lineDirection', 'ld')
            ->innerJoin('ld.line', 'l')
            ->innerJoin('ls.stop', 's')
            ->andWhere('l.number = :lineNumber')
            ->andWhere('ld.directionName = :directionName')
            ->andWhere('s.name = :stopName')
            ->setParameter('lineNumber', $lineNumber)
            ->setParameter('directionName', $directionName)
            ->setParameter('stopName', $stopName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findLastByLineAndDirection(string $lineNumber, string $directionName): ?LineStop
    {
        return $this->createQueryBuilder('ls')
            ->innerJoin('ls.lineDirection', 'ld')
            ->innerJoin('ld.line', 'l')
            ->andWhere('l.number = :lineNumber')
            ->andWhere('ld.directionName = :directionName')
            ->orderBy('ls.stop_order', 'DESC')
            ->setParameter('lineNumber', $lineNumber)
            ->setParameter('directionName', $directionName)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return LineStop[] Returns an array of LineStop objects
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

//    public function findOneBySomeField($value): ?LineStop
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
