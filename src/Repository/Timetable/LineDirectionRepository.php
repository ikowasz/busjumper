<?php

namespace App\Repository\Timetable;

use App\Entity\Timetable\LineDirection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LineDirection>
 */
class LineDirectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineDirection::class);
    }

    public function findOneByLineAndDirectionName(string $lineNumber, string $directionName): ?LineDirection
    {
        return $this->createQueryBuilder('ld')
            ->innerJoin('ld.line', 'l')
            ->andWhere('l.number = :lineNumber')
            ->andWhere('ld.directionName = :directionName')
            ->setParameter('lineNumber', $lineNumber)
            ->setParameter('directionName', $directionName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return LineDirection[] Returns an array of LineDirection objects
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

    //    public function findOneBySomeField($value): ?LineDirection
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
