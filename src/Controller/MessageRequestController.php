<?php

namespace App\Controller;

use App\Entity\MessageRequest;
use App\Entity\RequestStatus;
use App\Form\MessageRequestType;
use App\Repository\MessageRequestRepository;
use App\Repository\RequestStatusRepository;
use App\Security\MessageRequestVoter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message/request")
 */
class MessageRequestController extends AbstractController
{
    /**
     * @Route("/", name="message_request_index", methods="GET")
     */
    public function index(
        MessageRequestRepository $messageRequestRepository,
        Request $request,
        PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $messageRequestRepository->getAllByUserQuery($this->getUser()),
            $request->query->getInt('page', 1),
            $this->getParameter('knp_paginator.page_range')
        );

        return $this->render('message_request/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/new", name="message_request_new", methods="GET|POST")
     */
    public function new(Request $request, RequestStatusRepository $rsr): Response
    {
        $messageRequest = new MessageRequest();
        $form = $this->createForm(MessageRequestType::class, $messageRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRequest->setUser($this->getUser())
                ->setStatus($rsr->findOneBy(['code' => RequestStatus::STATUS_UNSEEN]));
            $em = $this->getDoctrine()->getManager();
            $em->persist($messageRequest);
            $em->flush();

            return $this->redirectToRoute('message_request_index');
        }

        return $this->render('message_request/new.html.twig', [
            'message_request' => $messageRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_request_show", methods="GET")
     */
    public function show(MessageRequest $messageRequest): Response
    {
        $this->denyAccessUnlessGranted(MessageRequestVoter::VIEW, $messageRequest);
        return $this->render('message_request/show.html.twig', ['message_request' => $messageRequest]);
    }

    /**
     * @Route("/{id}/edit", name="message_request_edit", methods="GET|POST")
     */
    public function edit(Request $request, MessageRequest $messageRequest): Response
    {
        $this->denyAccessUnlessGranted(MessageRequestVoter::EDIT, $messageRequest);
        $form = $this->createForm(MessageRequestType::class, $messageRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_request_edit', ['id' => $messageRequest->getId()]);
        }

        return $this->render('message_request/edit.html.twig', [
            'message_request' => $messageRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_request_delete", methods="DELETE")
     */
    public function delete(Request $request, MessageRequest $messageRequest): Response
    {
        $this->denyAccessUnlessGranted(MessageRequestVoter::DELETE, $messageRequest);
        if ($this->isCsrfTokenValid('delete'.$messageRequest->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($messageRequest);
            $em->flush();
        }

        return $this->redirectToRoute('message_request_index');
    }
}
