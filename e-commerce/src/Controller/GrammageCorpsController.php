<?php

namespace App\Controller;

use App\Entity\GrammageCorps;
use App\Form\GrammageCorpsType;
use App\Repository\GrammageCorpsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/grammage/corps')]
final class GrammageCorpsController extends AbstractController
{
    #[Route(name: 'app_grammage_corps_index', methods: ['GET'])]
    public function index(GrammageCorpsRepository $grammageCorpsRepository): Response
    {
        return $this->render('grammage_corps/index.html.twig', [
            'grammage_corps' => $grammageCorpsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_grammage_corps_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $grammageCorp = new GrammageCorps();
        $form = $this->createForm(GrammageCorpsType::class, $grammageCorp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($grammageCorp);
            $entityManager->flush();

            return $this->redirectToRoute('app_grammage_corps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grammage_corps/new.html.twig', [
            'grammage_corp' => $grammageCorp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grammage_corps_show', methods: ['GET'])]
    public function show(GrammageCorps $grammageCorp): Response
    {
        return $this->render('grammage_corps/show.html.twig', [
            'grammage_corp' => $grammageCorp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_grammage_corps_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GrammageCorps $grammageCorp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GrammageCorpsType::class, $grammageCorp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_grammage_corps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grammage_corps/edit.html.twig', [
            'grammage_corp' => $grammageCorp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grammage_corps_delete', methods: ['POST'])]
    public function delete(Request $request, GrammageCorps $grammageCorp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grammageCorp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($grammageCorp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_grammage_corps_index', [], Response::HTTP_SEE_OTHER);
    }
}
