<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Ingredient;
use App\Form\Admin\IngredientType;
use App\Repository\Admin\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/ingredient")
 */
class IngredientController extends AbstractController
{
    /**
     * @Route("/", name="admin_ingredient_index", methods={"GET"})
     */
    public function index(IngredientRepository $ingredientRepository): Response
    {
        return $this->render('admin/ingredient/index.html.twig', [
            'ingredients' => $ingredientRepository->findBy([],["category"=>'asc']),
        ]);
    }

    /**
     * @Route("/new", name="admin_ingredient_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();

            return $this->redirectToRoute('admin_ingredient_index');
        }

        return $this->render('admin/ingredient/new.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="admin_ingredient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ingredient $ingredient): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_ingredient_index');
        }

        return $this->render('admin/ingredient/edit.html.twig', [
            'ingredient' => $ingredient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_ingredient_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ingredient $ingredient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ingredient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_ingredient_index');
    }
}
