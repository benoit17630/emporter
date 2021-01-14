<?php

namespace App\Controller\Admin;

use App\Entity\Admin\OpeningDay;
use App\Form\Admin\OpeningDayType;
use App\Repository\Admin\OpeningDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/opening/day")
 */
class OpeningDayController extends AbstractController
{
    /**
     * @Route("/", name="admin_opening_day_index", methods={"GET"})
     */
    public function index(OpeningDayRepository $openingDayRepository): Response
    {
        return $this->render('admin/opening_day/index.html.twig', [
            'opening_days' => $openingDayRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_opening_day_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $openingDay = new OpeningDay();
        $form = $this->createForm(OpeningDayType::class, $openingDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($openingDay);
            $entityManager->flush();

            return $this->redirectToRoute('admin_opening_day_index');
        }

        return $this->render('admin/opening_day/new.html.twig', [
            'opening_day' => $openingDay,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="admin_opening_day_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OpeningDay $openingDay): Response
    {
        $form = $this->createForm(OpeningDayType::class, $openingDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_opening_day_index');
        }

        return $this->render('admin/opening_day/edit.html.twig', [
            'opening_day' => $openingDay,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_opening_day_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OpeningDay $openingDay): Response
    {
        if ($this->isCsrfTokenValid('delete'.$openingDay->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($openingDay);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_opening_day_index');
    }
}
