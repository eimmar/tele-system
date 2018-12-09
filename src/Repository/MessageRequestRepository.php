<?php

namespace App\Repository;

use App\Entity\MessageRequest;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MessageRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageRequest[]    findAll()
 * @method MessageRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRequestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MessageRequest::class);
    }

    /**
     * @param User $serviceType
     * @return QueryBuilder
     */
    public function getAllByUserQuery(User $user)
    {
        return $this->createQueryBuilder('mr')
            ->where('mr.user = :user')
            ->setParameter('user', $user);
    }

//    /**
//     * @return MessageRequest[] Returns an array of MessageRequest objects
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
    public function findOneBySomeField($value): ?MessageRequest
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
