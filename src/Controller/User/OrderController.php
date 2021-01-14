<?php

namespace App\Controller\User;

use App\Entity\User\Order;
use App\Form\User\OrderType;
use App\Repository\Admin\PizzaRepository;
use App\Repository\User\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="user_order_index", methods={"GET"})
     * @param OrderRepository $orderRepository
     * @return Response
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('user/order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_order_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request,PizzaRepository $pizzaRepository): Response
    {
        $pizzas= $pizzaRepository->findAll();
        $order = new Order();

        $order->setOrderNumber();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('user_order_index');
        }

        return $this->render('user/order/new.html.twig', [
            "pizzas"=> $pizzas,
            'order' => $order,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="user_order_show", methods={"GET"})
     * @param Order $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        return $this->render('user/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_order_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function edit(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_order_index');
        }

        return $this->render('user/order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="user_order_delete", methods={"DELETE"})
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_order_index');
    }
}
