<?php

namespace App\Controller;

use App\Entity\AntenneLongueur;
use App\Form\AntenneLongueurType;
use App\Repository\AntenneLongueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/antenne/longueur')]
final class AntenneLongueurController extends AbstractController
{
    #[Route(name: 'app_antenne_longueur_index', methods: ['GET'])]
    public function index(AntenneLongueurRepository $antenneLongueurRepository): Response
    {
        return $this->render('antenne_longueur/index.html.twig', [
            'antenne_longueurs' => $antenneLongueurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_antenne_longueur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $antenneLongueur = new AntenneLongueur();
        $form = $this->createForm(AntenneLongueurType::class, $antenneLongueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($antenneLongueur);
            $entityManager->flush();

            return $this->redirectToRoute('app_antenne_longueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('antenne_longueur/new.html.twig', [
            'antenne_longueur' => $antenneLongueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_antenne_longueur_show', methods: ['GET'])]
    public function show(AntenneLongueur $antenneLongueur): Response
    {
        return $this->render('antenne_longueur/show.html.twig', [
            'antenne_longueur' => $antenneLongueur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_antenne_longueur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AntenneLongueur $antenneLongueur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AntenneLongueurType::class, $antenneLongueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_antenne_longueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('antenne_longueur/edit.html.twig', [
            'antenne_longueur' => $antenneLongueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_antenne_longueur_delete', methods: ['POST'])]
    public function delete(Request $request, AntenneLongueur $antenneLongueur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$antenneLongueur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($antenneLongueur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_antenne_longueur_index', [], Response::HTTP_SEE_OTHER);
    }
}
