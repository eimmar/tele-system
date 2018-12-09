<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="order_index", methods="GET")
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig');
        return $this->render('order/index.html.twig', ['orders' => $orderRepository->findAll()]);
    }

       /**
     * @Route("/disapproved", name="disapproved_orders", methods="GET")
     */
    public function disapproved_list(OrderRepository $orderRepository): Response
    {
        return $this->render('order/disapproved_orders.html.twig');
    }

    /**
     * @Route("/new", name="order_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/{id}", name="user_orders", methods="GET")
     */
    public function user_orders(OrderRepository $orderRepository): Response
    {
       return $this->render('order/user_orders.html.twig');
        return $this->render('order/index.html.twig', ['orders' => $orderRepository->findAll()]);
    }
    // /**
    //  * @Route("/{id}", name="order_show", methods="GET")
    //  */
    // public function show(Order $order): Response
    // {
    //    // return $this->render('order/user_orders');
    //     return $this->render('order/show.html.twig', ['order' => $order]);
    // }

    /**
     * @Route("/{id}/edit", name="order_edit", methods="GET|POST")
     */
    public function edit(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_edit', ['id' => $order->getId()]);
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_delete", methods="DELETE")
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($order);
            $em->flush();
        }

        return $this->redirectToRoute('order_index');
    }
}
