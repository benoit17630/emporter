<?php

namespace App\Controller\Admin;

use App\Entity\Admin\OpeningTime;
use App\Form\Admin\OpeningTimeType;
use App\Repository\Admin\OpeningTimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/opening/time")
 */
class OpeningTimeController extends AbstractController
{
    /**
     * @Route("/", name="admin_opening_time_index", methods={"GET"})
     */
    public function index(OpeningTimeRepository $openingTimeRepository): Response
    {
        return $this->render('admin/opening_time/index.html.twig', [
            'opening_times' => $openingTimeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_opening_time_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $openingTime = new OpeningTime();
        $form = $this->createForm(OpeningTimeType::class, $openingTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($openingTime);
            $entityManager->flush();

            return $this->redirectToRoute('admin_opening_time_index');
        }

        return $this->render('admin/opening_time/new.html.twig', [
            'opening_time' => $openingTime,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="admin_opening_time_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OpeningTime $openingTime): Response
    {
        $form = $this->createForm(OpeningTimeType::class, $openingTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_opening_time_index');
        }

        return $this->render('admin/opening_time/edit.html.twig', [
            'opening_time' => $openingTime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_opening_time_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OpeningTime $openingTime): Response
    {
        if ($this->isCsrfTokenValid('delete'.$openingTime->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($openingTime);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_opening_time_index');
    }
}
