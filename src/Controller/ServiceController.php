<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Repository\OrderStatusRepository;
use App\Repository\OrderItemRepository;
use App\Entity\OrderStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

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
    //Tadas
     /**
     * @Route("/mobile", name="service_mobile_index", methods="GET")
     */
    public function index_mobile_user(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', ['services' => $serviceRepository->findAll()]);
    }

     //Tadas
     /**
     * @Route("/mobile/order", name="service_order", methods="POST")
     */
    public function order_service(ServiceRepository $serviceRepository, OrderRepository $orderRepository,OrderStatusRepository $orderStatusRepository, Request $request): Response
    {
        $user = $this->getUser();

      $serviceId = $request->request->get('service');
            $service = $this->getDoctrine()
            ->getRepository(Service::class)
            ->find($serviceId);

            if (!$service) {
                throw $this->createNotFoundException(
                    'No service found for id '.$serviceId
                );
            }
            if($service->getSpecialPrice() == 0){
                $total = $this->countPrice($request->request->get('date-from'),$request->request->get('date-to'),$service->getPrice());
            } else {
                $total = $this->countPrice($request->request->get('date-from'),$request->request->get('date-to'),$service->getSpecialPrice());
            }
        //searching for users order by user id
        //if found we dont need to create one
        if($request->request->get('service') != NULL){
            $orderItem = new OrderItem();
            $orderItem->setPrice($total);

            $dateFrom =  \DateTime::createFromFormat("Y-m-d",$request->request->get('date-from'));
            var_dump($dateFrom);
            $orderItem->setDateFrom($dateFrom);

            $dateTo =  \DateTime::createFromFormat("Y-m-d",$request->request->get('date-to'));
            $orderItem->setDateTo($dateTo);

            $orderItem->setServiceType('Mobile service');
          

            $orderItem->setOriginalService($service);

            $order = $orderRepository->findOneBy(['user' => $user]);

            //jeigu neatrado reikia kurti nauja
            if (!$order) {
               $order = new Order();
               $order->setStartDate($dateFrom);
               $order->setEndDate($dateTo);
               $order->setTotalSum($total);
               $order->setTax(21);
               $orderStatus = $orderStatusRepository->findOneBy(['id'=>2]);
               $order->setStatus($orderStatus);
               $order->setDateCreated( \DateTime::createFromFormat("Y-m-d",date('Y-m-d')));
               $order->setDateModified( \DateTime::createFromFormat("Y-m-d",date('Y-m-d')));
               $order->setUser($user);

               $em = $this->getDoctrine()->getManager();
               $em->persist($order);
               $em->flush();
            }
            
            $orderTotal = $order->getTotalSum();
            $orderTotal = $orderTotal+$total;
            $order->setTotalSum($orderTotal);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            
            $orderItem->setMainOrder($order);
            //sukurti nauja order item 
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderItem);
            $em->flush();
            
            return $this->redirectToRoute('user_orders');
        }
    }

    public function countPrice($dateFrom,$dateTo, $price){
        $year = date('Y', strtotime($dateTo)) - date('Y', strtotime($dateFrom));
        if($year < 0){
            return -1;
        }
        $total = $year*$price;
        $month = date('m', strtotime($dateTo)) - date('m', strtotime($dateFrom));
        if($month <= 0){
            $total = $total + $price;
        } else{
            $total=$total+$month*$price;
        }
        return $total;
    }

    //Tadas
     /**
     * @Route("/admin/mobile", name="service_mobile_index_admin", methods="GET")
     */
    public function index_mobile_admin(ServiceRepository $serviceRepository): Response
    {
       // return $this->render('service_mobile/index_admin.html.twig');
        return $this->render('service/index_admin.html.twig', ['services' => $serviceRepository->findAll()]);
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
     * @Route("/admin/new", name="service_new", methods="GET|POST")
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

            return $this->redirectToRoute('telecom_index_admin');
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

            return $this->redirectToRoute('service_mobile_index_admin', ['id' => $service->getId()]);
        }

        return $this->render('service/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/{id}/removeDiscount", name="remove_discount", methods="DELETE")
     */
    public function remove_discount(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid('deletediscount'.$service->getId(), $request->request->get('_token'))) {
            $service->setSpecialPrice(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
        }

        return $this->redirectToRoute('service_mobile_index_admin');
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

        return $this->redirectToRoute('service_mobile_index_admin');
    }
}
