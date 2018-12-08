<?php

namespace App\Repository;

use App\Entity\ServerVisit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServerVisit|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServerVisit|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServerVisit[]    findAll()
 * @method ServerVisit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerVisitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServerVisit::class);
    }

    /**
     * @param ServerVisit $visit
     * @return ServerVisit|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function similarVisitExists(ServerVisit $visit)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.ip = :ip')
            ->andWhere('s.visitDate = :visitDate')
            ->setParameters(
                [
                    'ip' => $visit->getIp(),
                    'visitDate' => $visit->getVisitDate()
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();
    }
//    /**
//     * @return ServerVisit[] Returns an array of ServerVisit objects
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
    public function findOneBySomeField($value): ?ServerVisit
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
