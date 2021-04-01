<?php

namespace App\Controller\Order;

use App\Cart\Cart;
use App\Entity\Admin\Order;
use App\Entity\Admin\OrderDetail;
use App\Entity\User;
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

    public function __Construct(OrderRepository $orderRepository){
        $this->orderRepository= $orderRepository;
    }

    /**
     * @Route("/commande", name="commande")
     */
    public function index(PizzaRepository $pizzaRepository): Response
    {
        $pizzas =$pizzaRepository->findAll();
        return $this->render('commande/index.html.twig', [
            "pizzas"=>$pizzas

        ]);
    }

    /**
     * @Route("/commande/cart/add/{id}", name="commande_add_to_cart")
     */
    public function addToCart(Cart $cart, $id): RedirectResponse
    {
        $cart->add($id);
        return $this->redirectToRoute("commande");
    }

    /**
     * @Route("/commande/cart/decrease/{id}", name="commande_decrease_to_cart")
     */
    public function decrease(Cart $cart, $id)
    {
        $cart->decrease($id);
        return $this->redirectToRoute('commande');
    }

    /**
     * @Route("/commande/recapitulatif", name="order_recap")
     * @param Request $request
     * @param User $user
     */
    public function orderAdd(Cart $cart,
                             PizzaRepository $pizzaRepository,
                             Request $request,
                             EntityManagerInterface $manager)
    {
        $form =$this->createForm(OrderType::class,null,[
            "user"=>$this->getUser()
        ]);
        $user = $this->getUser();
        $userId =$user->getId();
        $requet = $this->orderRepository->findLastId();
        $orderId = $requet[0]["id"]+1;


        $form->handleRequest($request);

        $date= new DateTime();

        $order =new Order();

        $order->setUser($user);
        $order->setState(0);
        $order->setOrderNumber($orderId."-".$userId."-".$date->format("d-m-y"));
        $manager->persist($order);

        foreach ($cart->getFull($pizzaRepository) as $pizza){
            $orderDetail = new OrderDetail();
            $orderDetail->setMyOrder($order);
            $orderDetail->setPizza($pizza["pizza"]->getName());
            $orderDetail->setQuantity($pizza["quantity"]);
            $orderDetail->setPrice($pizza["pizza"]->getPrice());
            $orderDetail->setTotal($pizza["pizza"]->getPrice() * $pizza["quantity"]);
            $manager->persist($orderDetail);

        }

        $manager->flush();

        return $this->render("commande/add.html.twig",[
            'cart'=> $cart->getFull($pizzaRepository)
        ]);

    }



}
