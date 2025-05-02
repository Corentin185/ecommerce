<?php

namespace App\Controller;

use App\Entity\Bouchon;
use App\Form\Bouchon1Type;
use App\Repository\BouchonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bouchon')]
final class BouchonController extends AbstractController
{
    #[Route(name: 'app_bouchon_index', methods: ['GET'])]
    public function index(BouchonRepository $bouchonRepository): Response
    {
        return $this->render('bouchon/index.html.twig', [
            'bouchons' => $bouchonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bouchon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bouchon = new Bouchon();
        $form = $this->createForm(Bouchon1Type::class, $bouchon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bouchon);
            $entityManager->flush();

            return $this->redirectToRoute('app_bouchon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bouchon/new.html.twig', [
            'bouchon' => $bouchon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bouchon_show', methods: ['GET'])]
    public function show(Bouchon $bouchon): Response
    {
        return $this->render('bouchon/show.html.twig', [
            'bouchon' => $bouchon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bouchon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bouchon $bouchon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Bouchon1Type::class, $bouchon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bouchon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bouchon/edit.html.twig', [
            'bouchon' => $bouchon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bouchon_delete', methods: ['POST'])]
    public function delete(Request $request, Bouchon $bouchon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bouchon->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bouchon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bouchon_index', [], Response::HTTP_SEE_OTHER);
    }
}
