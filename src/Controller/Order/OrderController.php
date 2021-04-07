<?php

namespace App\Controller\Order;

use App\Classes\Cart;
use App\Entity\Admin\Order;
use App\Entity\Admin\OrderDetail;
use App\Form\OrderType;
use App\Repository\Admin\OrderRepository;
use App\Repository\Admin\PizzaRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $orderRepository;

    public function __Construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/commande", name="commande")
     * @param PizzaRepository $pizzaRepository
     * @return Response
     */
    public function index(PizzaRepository $pizzaRepository): Response
    {
        $pizzas = $pizzaRepository->findAll();
        return $this->render('commande/index.html.twig', [
            "pizzas" => $pizzas

        ]);
    }

    /**
     * @Route("/commande/cart/add/{id}", name="commande_add_to_cart")
     * @param Cart $cart
     * @param $id
     * @return RedirectResponse
     */
    public function addToCart(Cart $cart, $id): RedirectResponse
    {
        $cart->add($id);
        return $this->redirectToRoute("commande");
    }

    /**
     * @Route("/commande/cart/decrease/{id}", name="commande_decrease_to_cart")
     * @param Cart $cart
     * @param $id
     * @return RedirectResponse
     */
    public function decrease(Cart $cart, $id): RedirectResponse
    {
        $cart->decrease($id);
        return $this->redirectToRoute('commande');
    }


    /**
     * @Route("/commande/recapitulatif", name="order_recap")
     * @param Cart $cart
     * @param PizzaRepository $pizzaRepository
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function orderAdd(Cart $cart,
                             PizzaRepository $pizzaRepository,
                             EntityManagerInterface $manager,Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(OrderType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $userId = $user->getId();

            $requet = $this->orderRepository->findLastId();

            $orderId =  $requet[0]["id"]+1;

            $date = new DateTime();


            $order = new Order();

            $order->setUser($user);
            $order->setState(0);
            $order->setOrderNumber($orderId . "-" . $userId . "-" . $date->format("d-m-y"));
            $order->setWantedAt($form->getData()->getWantedAt());

            $manager->persist($order);

            foreach ($cart->getFull($pizzaRepository) as $pizza) {
                $orderDetail = new OrderDetail();
                $orderDetail->setMyOrder($order);
                $orderDetail->setPizza($pizza["pizza"]->getName());
                $orderDetail->setQuantity($pizza["quantity"]);
                $orderDetail->setPrice($pizza["pizza"]->getPrice());
                $orderDetail->setTotal($pizza["pizza"]->getPrice() * $pizza["quantity"]);
                $manager->persist($orderDetail);

            }
            $manager->flush();
            return $this->render("commande/add.html.twig", [
                'cart' => $cart->getFull($pizzaRepository),
                "orderNumber" => $order->getOrderNumber()

            ]);
        }

        return $this->render("commande/recap.html.twig", [
            'cart' => $cart->getFull($pizzaRepository),
            "form"=>$form->createView()

        ]);
    }

    /**
     * @Route("/commande/merci/{stripSessionId}", name="order_validate")
     *
     */
    public function thanks($stripSessionId,
                          EntityManagerInterface $manager,
                          Cart $cart): Response
    {
        $order = $manager->getRepository(Order::class)->findOneBy(['stripSessionId'=>$stripSessionId]);
        if (!$order ||$order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        //je verifie que mon order est a bien le statue  0
        if ($order->getState() ==0){
            //je modifier le statue de ma commande a payer 1
            $order->setState(1);
            $manager->flush();
            //vider le pannier
            $cart->remove();

            //envoie d un email pour confirmer la commande


        }



        //afficher les quelque info de la commande de l utilisateur

        return $this->render('commande/order_success/index.html.twig', [
            'order'=>$order

        ]);
    }

    /**
     * @Route("/commande/erreur/{stripeSessionId}", name="order_cancel")
     * @param $stripSessionId
     * @param OrderRepository $orderRepository
     * @return Response
     */
    public function error($stripSessionId,
                          OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findOneBy(['stripSessionId'=>$stripSessionId]);

        if (!$order ||$order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        //envoyer un email a notre utilisateur pour lui indiquer l echec du paiment




        return $this->render('commande/order_cancel/index.html.twig', [
            'order'=>$order

        ]);
    }






}
