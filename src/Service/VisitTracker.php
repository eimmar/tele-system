<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.12.8
 * Time: 21.22
 */

namespace App\Service;

use App\Entity\ServerVisit;
use App\Entity\User;
use App\Repository\ServerVisitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VisitTracker
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * RegistrationListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Request $request
     */
    public function trackVisit($request)
    {
        /** @var User|null $user */
        $user = $this->tokenStorage->getToken() ? $this->tokenStorage->getToken()->getUser() : null;
        if ($user instanceof User) {
            $user->setLastVisitDate(new \DateTime());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } else {
            $visit = new ServerVisit();
            $visit->setVisitDate(new \DateTime())
                ->setIp($request->getClientIp());

            /** @var ServerVisitRepository $vr */
            $vr = $this->entityManager->getRepository('App:ServerVisit');
            if (!$vr->similarVisitExists($visit)) {
                $this->entityManager->persist($visit);
                $this->entityManager->flush();
            }
        }
    }
}