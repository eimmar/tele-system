<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use App\Security\InvoiceVoter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invoice")
 */
class InvoiceController extends AbstractController
{
    /**
     * @Route("/", name="invoice_index", methods="GET")
     */
    public function index(
        InvoiceRepository $invoiceRepository,
        Request $request,
        PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $invoiceRepository->getAllByUserQuery($this->getUser()),
            $request->query->getInt('page', 1),
            $this->getParameter('knp_paginator.page_range')
        );

        return $this->render('invoice/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/{id}", name="invoice_show", methods="GET")
     */
    public function show(Invoice $invoice): Response
    {
//        if ($invoice->getMainOrder()->getUser() !== $this->getUser()) {
            $this->denyAccessUnlessGranted(InvoiceVoter::VIEW, $invoice);
//        }
        return $this->render('invoice/show.html.twig', ['invoice' => $invoice]);
    }
}
