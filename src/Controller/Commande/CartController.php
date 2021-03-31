<?php

namespace App\Controller\Commande;

use App\Cart\Cart;
use App\Repository\Admin\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/commande/panier", name="cart")
     */
    public function index(Cart $cart, PizzaRepository $pizzaRepository): Response
    {
        $pizzas=$cart->getFull($pizzaRepository);

        return $this->render('commande/cart/index.html.twig', [
            'pizzas'=> $pizzas
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {

        $cart->add($id);
        return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(Cart $cart, $id)
    {
        $cart->decrease($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/delete/{id}", name="delete_to_cart")
     */
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('commande');
    }
}
