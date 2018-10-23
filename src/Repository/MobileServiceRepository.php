<?php

namespace App\Repository;

use App\Entity\MobileService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MobileService|null find($id, $lockMode = null, $lockVersion = null)
 * @method MobileService|null findOneBy(array $criteria, array $orderBy = null)
 * @method MobileService[]    findAll()
 * @method MobileService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MobileServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MobileService::class);
    }

//    /**
//     * @return MobileService[] Returns an array of MobileService objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MobileService
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
