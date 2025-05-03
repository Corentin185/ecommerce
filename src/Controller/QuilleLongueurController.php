<?php

namespace App\Controller;

use App\Entity\QuilleLongueur;
use App\Form\QuilleLongueurType;
use App\Repository\QuilleLongueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quille/longueur')]
final class QuilleLongueurController extends AbstractController
{
    #[Route(name: 'app_quille_longueur_index', methods: ['GET'])]
    public function index(QuilleLongueurRepository $quilleLongueurRepository): Response
    {
        return $this->render('quille_longueur/index.html.twig', [
            'quille_longueurs' => $quilleLongueurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quille_longueur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quilleLongueur = new QuilleLongueur();
        $form = $this->createForm(QuilleLongueurType::class, $quilleLongueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quilleLongueur);
            $entityManager->flush();

            return $this->redirectToRoute('app_quille_longueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quille_longueur/new.html.twig', [
            'quille_longueur' => $quilleLongueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quille_longueur_show', methods: ['GET'])]
    public function show(QuilleLongueur $quilleLongueur): Response
    {
        return $this->render('quille_longueur/show.html.twig', [
            'quille_longueur' => $quilleLongueur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quille_longueur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, QuilleLongueur $quilleLongueur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuilleLongueurType::class, $quilleLongueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_quille_longueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quille_longueur/edit.html.twig', [
            'quille_longueur' => $quilleLongueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quille_longueur_delete', methods: ['POST'])]
    public function delete(Request $request, QuilleLongueur $quilleLongueur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quilleLongueur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($quilleLongueur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quille_longueur_index', [], Response::HTTP_SEE_OTHER);
    }
}
