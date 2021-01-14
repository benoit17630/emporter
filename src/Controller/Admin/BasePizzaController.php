<?php

namespace App\Controller\Admin;

use App\Entity\Admin\BasePizza;
use App\Form\Admin\BasePizzaType;
use App\Repository\Admin\BasePizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/base/pizza")
 */
class BasePizzaController extends AbstractController
{
    /**
     * @Route("/", name="admin_base_pizza_index", methods={"GET"})
     */
    public function index(BasePizzaRepository $basePizzaRepository): Response
    {
        return $this->render('admin/base_pizza/index.html.twig', [
            'base_pizzas' => $basePizzaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_base_pizza_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $basePizza = new BasePizza();
        $form = $this->createForm(BasePizzaType::class, $basePizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($basePizza);
            $entityManager->flush();

            return $this->redirectToRoute('admin_base_pizza_index');
        }

        return $this->render('admin/base_pizza/new.html.twig', [
            'base_pizza' => $basePizza,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="admin_base_pizza_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BasePizza $basePizza): Response
    {
        $form = $this->createForm(BasePizzaType::class, $basePizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_base_pizza_index');
        }

        return $this->render('admin/base_pizza/edit.html.twig', [
            'base_pizza' => $basePizza,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_base_pizza_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BasePizza $basePizza): Response
    {
        if ($this->isCsrfTokenValid('delete'.$basePizza->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($basePizza);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_base_pizza_index');
    }
}
