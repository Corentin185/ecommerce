<?php

namespace App\Controller;

use App\Entity\AntenneCouleur;
use App\Form\AntenneCouleurType;
use App\Repository\AntenneCouleurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/antenne/couleur')]
final class AntenneCouleurController extends AbstractController
{
    #[Route(name: 'app_antenne_couleur_index', methods: ['GET'])]
    public function index(AntenneCouleurRepository $antenneCouleurRepository): Response
    {
        return $this->render('antenne_couleur/index.html.twig', [
            'antenne_couleurs' => $antenneCouleurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_antenne_couleur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, AntenneCouleurRepository $antenneCouleurRepository): Response
    {
        $antenneCouleur = new AntenneCouleur();
        $form = $this->createForm(AntenneCouleurType::class, $antenneCouleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($antenneCouleur);
            $entityManager->flush();

            return $this->redirectToRoute('app_antenne_couleur_index', [], Response::HTTP_SEE_OTHER);
        }

        $couleurs = $antenneCouleurRepository->findAll();

        return $this->render('antenne_couleur/new.html.twig', [
            'antenne_couleur' => $antenneCouleur,
            'form' => $form,
            'couleurs' => $couleurs,
        ]);
    }

    #[Route('/{id}', name: 'app_antenne_couleur_show', methods: ['GET'])]
    public function show(AntenneCouleur $antenneCouleur): Response
    {
        return $this->render('antenne_couleur/show.html.twig', [
            'antenne_couleur' => $antenneCouleur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_antenne_couleur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AntenneCouleur $antenneCouleur, EntityManagerInterface $entityManager, AntenneCouleurRepository $antenneCouleurRepository): Response
    {
        $form = $this->createForm(AntenneCouleurType::class, $antenneCouleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_antenne_couleur_index', [], Response::HTTP_SEE_OTHER);
        }

        $couleurs = $antenneCouleurRepository->findAll();

        return $this->render('antenne_couleur/edit.html.twig', [
            'antenne_couleur' => $antenneCouleur,
            'form' => $form,
            'couleurs' => $couleurs,
        ]);
    }

    #[Route('/{id}', name: 'app_antenne_couleur_delete', methods: ['POST'])]
    public function delete(Request $request, AntenneCouleur $antenneCouleur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $antenneCouleur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($antenneCouleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_antenne_couleur_index', [], Response::HTTP_SEE_OTHER);
    }

    // ✅ Nouvelle route pour insérer les couleurs
    #[Route('/seed', name: 'app_antenne_couleur_seed', methods: ['GET'])]
    public function seed(EntityManagerInterface $entityManager): Response
    {
        $couleurs = ['rouge', 'noir', 'jaune', 'orange', 'vert'];

        foreach ($couleurs as $nom) {
            $couleur = new AntenneCouleur();
            $couleur->setCouleur($nom); // Assure-toi que ton entité a bien setCouleur()
            $entityManager->persist($couleur);
        }

        $entityManager->flush();

        return new Response('✅ Couleurs insérées avec succès !');
    }
}
