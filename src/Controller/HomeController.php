<?php

namespace App\Controller;


use App\Repository\Admin\AdressRepository;
use App\Repository\Admin\IngredientRepository;
use App\Repository\Admin\OpeningDayRepository;
use App\Repository\Admin\OpeningTimeRepository;
use App\Repository\Admin\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param PizzaRepository $pizzaRepository
     * @param OpeningTimeRepository $timeRepository
     * @param IngredientRepository $ingredientRepository
     * @param Request $request
     * @return Response
     */
    public function index(PizzaRepository $pizzaRepository,
                          OpeningTimeRepository $timeRepository,
                          OpeningDayRepository $openingDayRepository,
                          IngredientRepository $ingredientRepository,
                          Request $request,
                          AdressRepository $adressRepository): Response
    {

        $horaires =$timeRepository->findAll();
        $days= $openingDayRepository->findAll();
        $adresss = $adressRepository->findAll();
        $pizza = $pizzaRepository->findBy([],["price"=>'asc']);

        $search = $request->query->get('search');

        if ( !empty($search) ) {

            // j'appelle ma requête personalisée de repository
           $ingredients = $ingredientRepository->searchByIngredients($search);

            return $this->render("home/search.html.twig",[
                    'ingredients'=>$ingredients

                ]
            );
        }

        return $this->render('home/index.html.twig', [
            "pizzas"=> $pizza,
            'horaires'=> $horaires,
            "days"=>$days,
            "adresss"=>$adresss

        ]);
    }
}
