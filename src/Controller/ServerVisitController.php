<?php

namespace App\Controller;

use App\Entity\ServerVisit;
use App\Form\ServerVisitType;
use App\Repository\ServerVisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/server/visit")
 */
class ServerVisitController extends AbstractController
{
    /**
     * @Route("/", name="server_visit_index", methods="GET")
     */
    public function index(ServerVisitRepository $serverVisitRepository): Response
    {
        return $this->render('server_visit/index.html.twig', ['server_visits' => $serverVisitRepository->findAll()]);
    }

    /**
     * @Route("/{id}", name="server_visit_show", methods="GET")
     */
    public function show(ServerVisit $serverVisit): Response
    {
        return $this->render('server_visit/show.html.twig', ['server_visit' => $serverVisit]);
    }

    /**
     * @Route("/{id}", name="server_visit_delete", methods="DELETE")
     */
    public function delete(Request $request, ServerVisit $serverVisit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serverVisit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($serverVisit);
            $em->flush();
        }

        return $this->redirectToRoute('server_visit_index');
    }
}
