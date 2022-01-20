<?php

namespace App\Controller;

use App\Entity\Energy;
use App\Form\EnergyType;
use App\Repository\EnergyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnergyController extends AbstractController
{
    /**
     * @Route("/", name="energy_index", methods={"GET"})
     */
    public function index(EnergyRepository $energyRepository): Response
    {
        return $this->render('energy/index.html.twig', [
            'energies' => $energyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="energy_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $energy = new Energy();
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($energy);
            $entityManager->flush();

            return $this->redirectToRoute('energy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('energy/new.html.twig', [
            'energy' => $energy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="energy_show", methods={"GET"})
     */
    public function show(Energy $energy): Response
    {
        return $this->render('energy/show.html.twig', [
            'energy' => $energy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="energy_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Energy $energy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('energy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('energy/edit.html.twig', [
            'energy' => $energy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="energy_delete", methods={"POST"})
     */
    public function delete(Request $request, Energy $energy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$energy->getId(), $request->request->get('_token'))) {
            $entityManager->remove($energy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('energy_index', [], Response::HTTP_SEE_OTHER);
    }
}
