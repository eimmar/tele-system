<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salary_management")
 */
class SalaryController extends AbstractController
{
    /**
     * @Route("/", name="salary_index", methods="GET")
     */
    public function index(userRepository $userRepository): Response
    {
        return $this->render('salary_management/index.html.twig');
    }
}