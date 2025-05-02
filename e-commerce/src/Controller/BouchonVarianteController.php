<?php

namespace App\Controller;

use App\Entity\BouchonVariante;
use App\Form\BouchonVarianteType;
use App\Repository\BouchonVarianteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Bouchon;






#[Route('/bouchonVariantes')]
final class BouchonVarianteController extends AbstractController
{
    #[Route('/', name: 'app_bouchon_variante_index', methods: ['GET'])]
    public function index(BouchonVarianteRepository $bouchonVarianteRepository): Response
    {
        return $this->render('bouchon_variante/index.html.twig', [
            'bouchon_variantes' => $bouchonVarianteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bouchon_variante_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bouchonVariante = new BouchonVariante();
        $form = $this->createForm(BouchonVarianteType::class, $bouchonVariante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bouchonVariante);
            $entityManager->flush();

            return $this->redirectToRoute('app_bouchon_variante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bouchon_variante/new.html.twig', [
            'bouchon_variante' => $bouchonVariante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bouchon_variante_show', methods: ['GET'])]
    public function filterByBouchonId(Bouchon $bouchon, BouchonVarianteRepository $bouchonVarianteRepository): Response
    {
        $variantes = $bouchonVarianteRepository->findBy(['bouchon' => $bouchon]);

        return $this->render('bouchon_variante/index.html.twig', [
            'bouchon_variantes' => $variantes,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_bouchon_variante_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BouchonVariante $bouchonVariante, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BouchonVarianteType::class, $bouchonVariante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bouchon_variante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bouchon_variante/edit.html.twig', [
            'bouchon_variante' => $bouchonVariante,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bouchon_variante_delete', methods: ['POST'])]
    public function delete(Request $request, BouchonVariante $bouchonVariante, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bouchonVariante->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bouchonVariante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bouchon_variante_index', [], Response::HTTP_SEE_OTHER);
    }
}
