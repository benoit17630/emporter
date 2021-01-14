<?php

namespace App\Controller;


use App\Repository\Admin\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/pizza", name="api_pizza")
     */
    public function index(PizzaRepository $pizzaRepository): Response
    {

        $pizza= $pizzaRepository->findAll();
        $encoder= [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];


    }
}
