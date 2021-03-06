<?php

namespace App\Repository;

use App\Entity\DateBlocked;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DateBlocked|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateBlocked|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateBlocked[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateBlockedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateBlocked::class);
    }

     /**
      * @return DateBlocked[] Returns an array of DateBlocked objects
      */
    public function findAll(): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.end >= :now')
            ->setParameter('now', new \DateTime('now'))
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?DateBlocked
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
