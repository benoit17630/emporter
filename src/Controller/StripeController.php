<?php

namespace App\Controller;

use App\Entity\Admin\Order;
use Doctrine\ORM\EntityManagerInterface;

use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{orderNumber}", name="stripe_create_session")
     * @param $orderNumber
     * @param EntityManagerInterface $manager
     * @return Response
     * @throws ApiErrorException
     */
    public function index($orderNumber,EntityManagerInterface $manager): Response
    {

        $product_for_stripe= [];
        $YOUR_DOMAIN = 'https://127.0.0.1:8000/';
        $order=$manager->getRepository(Order::class)->findOneBy(['orderNumber'=>$orderNumber]);
        if (!$order){
            new JsonResponse(['error' => 'order']);
        }
        foreach ($order->getOrderDetails()->getValues() as $pizza) {
            $product_for_stripe[]=[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $pizza->getPrice()*100,
                    'product_data' => [
                        'name' => $pizza->getPizza(),

                    ],
                ],
                'quantity' => $pizza->getQuantity(),
            ];
        }
Stripe::setApiKey("sk_test_51IbR79D1gv1P5Wk8aFtzzu20tlyPZprAaRH0gKV5c4fyadfR33T8CzD8aoX9UOo7SeQvkjd0EBTXcBTwotfUimYK005sla3BUu");
        $checkout_session = Session::create([
            'customer_email'=>$this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                $product_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . 'commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . 'commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);
        $order->setStripSessionId($checkout_session->id);
        $manager->flush();
       $response= new JsonResponse(['id' => $checkout_session->id]);
       return $response;
    }
}
