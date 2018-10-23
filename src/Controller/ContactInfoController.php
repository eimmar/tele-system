<?php

namespace App\Controller;

use App\Entity\ContactInfo;
use App\Form\ContactInfoType;
use App\Repository\ContactInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact/info")
 */
class ContactInfoController extends AbstractController
{
    /**
     * @Route("/", name="contact_info_index", methods="GET")
     */
    public function index(ContactInfoRepository $contactInfoRepository): Response
    {
        return $this->render('contact_info/index.html.twig', ['contact_infos' => $contactInfoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="contact_info_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $contactInfo = new ContactInfo();
        $form = $this->createForm(ContactInfoType::class, $contactInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactInfo);
            $em->flush();

            return $this->redirectToRoute('contact_info_index');
        }

        return $this->render('contact_info/new.html.twig', [
            'contact_info' => $contactInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_info_show", methods="GET")
     */
    public function show(ContactInfo $contactInfo): Response
    {
        return $this->render('contact_info/show.html.twig', ['contact_info' => $contactInfo]);
    }

    /**
     * @Route("/{id}/edit", name="contact_info_edit", methods="GET|POST")
     */
    public function edit(Request $request, ContactInfo $contactInfo): Response
    {
        $form = $this->createForm(ContactInfoType::class, $contactInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_info_edit', ['id' => $contactInfo->getId()]);
        }

        return $this->render('contact_info/edit.html.twig', [
            'contact_info' => $contactInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_info_delete", methods="DELETE")
     */
    public function delete(Request $request, ContactInfo $contactInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactInfo->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contactInfo);
            $em->flush();
        }

        return $this->redirectToRoute('contact_info_index');
    }
}
