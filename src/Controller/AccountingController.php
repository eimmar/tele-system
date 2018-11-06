<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/accounting")
 */
class AccountingController extends AbstractController
{
    /**
     * @Route("/", name="accounting_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('accounting_main/index.html.twig');
    }

     /**
     * @Route("/admin", name="accounting_index_admin", methods="GET")
     */
    public function index_admin(): Response
    {
        return $this->render('accounting_main/index_admin.html.twig');
    }

    
}
