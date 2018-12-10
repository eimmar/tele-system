<?php

namespace App\Repository;

use App\Entity\Invoice;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    /**
     * @param User $serviceType
     * @return QueryBuilder
     */
    public function getAllByUserQuery(User $user)
    {
        return $this->createQueryBuilder('i')
            ->add('from', Invoice::class . ' i LEFT JOIN i.mainOrder o')
            ->where('o.user = :user')
            ->setParameter('user', $user);
    }
}
