<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\OrderStatus;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusRepository;
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
        return $this->render('order/disapproved_orders.html.twig',['orders' => $orderRepository->findAll()]);
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
     * @Route("/orderedItem/{id}", name="delete_ordered_item", methods="DELETE")
     */
    public function delete_ordered_item(OrderRepository $orderRepository, Request $request, OrderItem $orderItem): Response
    {
        echo 'tadas';
        if ($this->isCsrfTokenValid('delete'.$orderItem->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderItem);
            $em->flush();
        }
        return $this->redirectToRoute('user_orders');
        
    }

    /**
     * @Route("/approve/{id}", name="approve_order", methods="POST")
     */
    public function approve_order(OrderRepository $orderRepository,OrderStatusRepository $orderStatusRepository, Order $order,Request $request): Response
    {
        if ($this->isCsrfTokenValid('approve'.$order->getId(), $request->request->get('_token'))) {
            $orderStatus = $orderStatusRepository->findOneBy(['id'=>5]);
            $order->setStatus($orderStatus);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
        }

        return $this->redirectToRoute('disapproved_orders');       
    }
     /**
     * @Route("/block/{id}", name="block_order", methods="POST")
     */
    public function block_order(OrderRepository $orderRepository, OrderStatusRepository $orderStatusRepository, Order $order,Request $request): Response
    {
        if ($this->isCsrfTokenValid('block'.$order->getId(), $request->request->get('_token'))) {
            $orderStatus = $orderStatusRepository->findOneBy(['id'=>4]);
            $order->setStatus($orderStatus);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
        }

        return $this->redirectToRoute('disapproved_orders');       
    }

    /**
     * @Route("/view", name="user_orders", methods="GET")
     */
    public function user_orders(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        if(!$user){
            return $this->render('telecommunication_main/index.html.twig');
        } else {
            $orders = $orderRepository->findOneBy(['user' => $user]);
        $orderedItems = $orders->getOrderItems();
       //return $this->render('order/user_orders.html.twig');
        return $this->render('order/index.html.twig', ['orders' => $orders, 'orderedItems'=> $orderedItems]);
        }       
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
