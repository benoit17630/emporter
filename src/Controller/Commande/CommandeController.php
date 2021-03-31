<?php

namespace App\Controller\Commande;

use App\Cart\Cart;
use App\Repository\Admin\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
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
}
