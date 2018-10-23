<?php

namespace App\Repository;

use App\Entity\ServiceRestriction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServiceRestriction|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceRestriction|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceRestriction[]    findAll()
 * @method ServiceRestriction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRestrictionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServiceRestriction::class);
    }

//    /**
//     * @return ServiceRestriction[] Returns an array of ServiceRestriction objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServiceRestriction
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
