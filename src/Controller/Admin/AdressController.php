<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Adress;
use App\Form\Admin\AdressType;
use App\Repository\Admin\AdressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/adress")
 */
class AdressController extends AbstractController
{
    /**
     * @Route("/", name="admin_adress_index", methods={"GET"})
     */
    public function index(AdressRepository $adressRepository): Response
    {
        return $this->render('admin/adress/index.html.twig', [
            'adresses' => $adressRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_adress_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $adress = new Adress();
        $form = $this->createForm(AdressType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adress);
            $entityManager->flush();

            return $this->redirectToRoute('admin_adress_index');
        }

        return $this->render('admin/adress/new.html.twig', [
            'adress' => $adress,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="admin_adress_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Adress $adress): Response
    {
        $form = $this->createForm(AdressType::class, $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_adress_index');
        }

        return $this->render('admin/adress/edit.html.twig', [
            'adress' => $adress,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_adress_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Adress $adress): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adress->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_adress_index');
    }
}
