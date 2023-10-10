<?php

namespace App\Repository;

use App\Entity\Wedded;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wedded>
 *
 * @method Wedded|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wedded|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wedded[]    findAll()
 * @method Wedded[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeddedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wedded::class);
    }

//    /**
//     * @return Wedded[] Returns an array of Wedded objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Wedded
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
