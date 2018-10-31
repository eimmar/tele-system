<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/telecom")
 */
class TelecomController extends AbstractController
{
    /**
     * @Route("/", name="telecom_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('telecommunication_main/index.html.twig');
    }

     /**
     * @Route("/admin", name="telecom_index_admin", methods="GET")
     */
    public function index_admin(): Response
    {
        return $this->render('telecommunication_main/index_admin.html.twig');
    }

    
}
