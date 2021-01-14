<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Pizza;
use App\Form\Admin\PizzaType;
use App\Repository\Admin\CategoryRepository;
use App\Repository\Admin\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/admin/pizza")
 */
class PizzaController extends AbstractController
{
    /**
     * @Route("/", name="admin_pizza_index", methods={"GET"})
     * @param PizzaRepository $pizzaRepository
     * @return Response
     */
    public function index(PizzaRepository $pizzaRepository): Response
    {
        return $this->render('admin/pizza/index.html.twig', [
            'pizzas' => $pizzaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_pizza_new", methods={"GET","POST"})
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function new(Request $request,
                        CategoryRepository $categoryRepository,
                        SluggerInterface $slugger
                       ): Response
    {
        $pizza = new Pizza();

        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        $categorys =$categoryRepository->findAll();


        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile){

                $originalFilename = pathinfo($imageFile->getClientOriginalName(),PATHINFO_FILENAME);

                $safeFilename= $slugger->slug($originalFilename);

                $newFilename = $safeFilename.'_'.uniqid().'.'.$imageFile->guessextension();


                $imageFile->move(

                    $this->getParameter('images_directory'),

                    $newFilename

                );

                $pizza->setImage($newFilename);

            }



                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pizza);

                $entityManager->flush();
                $this->addFlash(

                    'sucess',

                    "la pizza a ete créer"

                );


                return $this->redirectToRoute('admin_pizza_index');
            }

            return $this->render('admin/pizza/new.html.twig', [
                'pizza' => $pizza,
                'form' => $form->createView(),
                "categorys"=>$categorys,

            ]);
        }


        /**
         * @Route("/{id}/edit", name="admin_pizza_edit", methods={"GET","POST"})
         * @param Request $request
         * @param Pizza $pizza
         * @param CategoryRepository $categoryRepository
         * @return Response
         */
        public function edit(Request $request,
                             Pizza $pizza,
                             CategoryRepository $categoryRepository,
                             SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);
        $categorys =$categoryRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile){

                $originalFilename = pathinfo($imageFile->getClientOriginalName(),PATHINFO_FILENAME);

                $safeFilename= $slugger->slug($originalFilename);

                $newFilename = $safeFilename.'_'.uniqid().'.'.$imageFile->guessextension();


                $imageFile->move(

                    $this->getParameter('images_directory'),

                    $newFilename

                );

                $pizza->setImage($newFilename);

            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_pizza_index');
        }

        return $this->render('admin/pizza/edit.html.twig', [
            'pizza' => $pizza,
            'form' => $form->createView(),
            "categorys"=>$categorys
        ]);
    }

    /**
     * @Route("/{id}", name="admin_pizza_delete", methods={"DELETE"})
     * @param Request $request
     * @param Pizza $pizza
     * @return Response
     */
    public function delete(Request $request, Pizza $pizza): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pizza->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pizza);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_pizza_index');
    }
}
