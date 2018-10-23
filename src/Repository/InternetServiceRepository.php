<?php

namespace App\Repository;

use App\Entity\InternetService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InternetService|null find($id, $lockMode = null, $lockVersion = null)
 * @method InternetService|null findOneBy(array $criteria, array $orderBy = null)
 * @method InternetService[]    findAll()
 * @method InternetService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternetServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InternetService::class);
    }

//    /**
//     * @return InternetService[] Returns an array of InternetService objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InternetService
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
