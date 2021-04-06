<?php


namespace App\Classes;


use App\Repository\Admin\PizzaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $manager;


    public function __construct(SessionInterface $session,
                                EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->manager = $manager;


    }

    public function add($id)
    {
        $cart = $this->session->get('cart',[]);

        if (empty($cart[$id]))
        {
            $cart[$id]=1;
        }else
         {
            $cart[$id]++;
         }

        $this->session->set('cart',$cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get('cart',[]);
        unset($cart[$id]);
        $this->session->set('cart',$cart);
    }

    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);
        if ($cart[$id] === 1) {
            unset($cart[$id]);
        } else {
            $cart[$id]--;
        }

        $this->session->set('cart', $cart);
    }

    public function getFull(PizzaRepository $pizzaRepository)
    {
        $finalCart= [];

        $cart = $this->session->get('cart',[]);

        if (!empty($cart)){
            $pizza =null;
            foreach ($cart as $id =>$quantity){

               $pizza =$pizzaRepository->findOneBy(["id"=>$id]);
                if (!$pizza){
                    $this->delete($id);
                    continue ;
                }
                $finalCart[]= [
                    'pizza'=>$pizza,
                    "quantity"=> $quantity
                ];
            }

        }
        return $finalCart;
    }
}