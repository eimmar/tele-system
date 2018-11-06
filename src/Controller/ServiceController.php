<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
     /**
     * @Route("/service_list", name="service_list_index", methods="GET")
     */
    public function index_list_user(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/service_list.html.twig');
    }
    /**
     * @Route("/", name="service_index", methods="GET")
     */
    public function index_user(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig');
       // return $this->render('service/index.html.twig', ['services' => $serviceRepository->findAll()]);
    }
      /**
     * @Route("/admin", name="service_index_admin", methods="GET")
     */
    public function index_admin(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index_admin.html.twig');
       // return $this->render('service/index.html.twig', ['services' => $serviceRepository->findAll()]);
    }

     /**
     * @Route("/mobile", name="service_mobile_index", methods="GET")
     */
    public function index_mobile_user(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service_mobile/index.html.twig');
       // return $this->render('service/index.html.twig', ['services' => $serviceRepository->findAll()]);
    }


     /**
     * @Route("/admin/mobile", name="service_mobile_index_admin", methods="GET")
     */
    public function index_mobile_admin(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service_mobile/index_admin.html.twig');
       // return $this->render('service/index.html.twig', ['services' => $serviceRepository->findAll()]);
    }
    /**
     * @Route("/mobile/special", name="service_mobile_special", methods="GET")
     */
    public function special_offer(): Response
    {
        return $this->render('service_mobile/special_offer.html.twig');
    }
      /**
     * @Route("/mobile/special/{id}", name="service_mobile_special_delete", methods="GET")
     */
    public function delete_special_offer(): Response
    {
        return $this->redirectToRoute('service_mobile_index_admin');
    }

    /**
     * @Route("/new", name="service_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->redirectToRoute('service_index');
        }

        return $this->render('service/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_show", methods="GET")
     */
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', ['service' => $service]);
    }

    /**
     * @Route("/{id}/edit", name="service_edit", methods="GET|POST")
     */
    public function edit(Request $request, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_edit', ['id' => $service->getId()]);
        }

        return $this->render('service/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="service_delete", methods="DELETE")
     */
    public function delete(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($service);
            $em->flush();
        }

        return $this->redirectToRoute('service_index');
    }
}
