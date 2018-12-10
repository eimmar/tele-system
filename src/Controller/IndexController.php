<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.2.28
 * Time: 18.20
 */
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(EntityManagerInterface $em)
    {
//        $user = $this->getUser();
//        $user->addRole('ROLE_MANAGER');
//        $em->persist($user);
//        $em->flush();
        return $this->render('index/index.html.twig');
    }

    /**
     * @Route("/contacts", name="contacts")
     */
    public function contacts()
    {
        return $this->render('index/contacts.html.twig');
    }
}
