<?php

namespace App\Repository;

use App\Entity\ClockingProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClockProject>
 *
 * @method ClockProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClockProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClockProject[]    findAll()
 * @method ClockProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClockingProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClockingProject::class);
    }

//    /**
//     * @return ClockProject[] Returns an array of ClockProject objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ClockProject
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
