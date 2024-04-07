<?php

namespace App\Repository;

use App\Entity\GuestList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GuestList>
 *
 * @method GuestList|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuestList|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuestList[]    findAll()
 * @method GuestList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuestListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuestList::class);
    }

//    /**
//     * @return GuestList[] Returns an array of GuestList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GuestList
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
