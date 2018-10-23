<?php

namespace App\Controller;

use App\Entity\ServiceRestriction;
use App\Form\ServiceRestrictionType;
use App\Repository\ServiceRestrictionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service/restriction")
 */
class ServiceRestrictionController extends AbstractController
{
    /**
     * @Route("/", name="service_restriction_index", methods="GET")
     */
    public function index(ServiceRestrictionRepository $serviceRestrictionRepository): Response
    {
        return $this->render('service_restriction/index.html.twig', ['service_restrictions' => $serviceRestrictionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="service_restriction_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $serviceRestriction = new ServiceRestriction();
        $form = $this->createForm(ServiceRestrictionType::class, $serviceRestriction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($serviceRestriction);
            $em->flush();

            return $this->redirectToRoute('service_restriction_index');
        }

        return $this->render('service_restriction/new.html.twig', [
            'service_restriction' => $serviceRestriction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_restriction_show", methods="GET")
     */
    public function show(ServiceRestriction $serviceRestriction): Response
    {
        return $this->render('service_restriction/show.html.twig', ['service_restriction' => $serviceRestriction]);
    }

    /**
     * @Route("/{id}/edit", name="service_restriction_edit", methods="GET|POST")
     */
    public function edit(Request $request, ServiceRestriction $serviceRestriction): Response
    {
        $form = $this->createForm(ServiceRestrictionType::class, $serviceRestriction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_restriction_edit', ['id' => $serviceRestriction->getId()]);
        }

        return $this->render('service_restriction/edit.html.twig', [
            'service_restriction' => $serviceRestriction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_restriction_delete", methods="DELETE")
     */
    public function delete(Request $request, ServiceRestriction $serviceRestriction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceRestriction->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($serviceRestriction);
            $em->flush();
        }

        return $this->redirectToRoute('service_restriction_index');
    }
}
