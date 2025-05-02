<?php

namespace App\Controller;

use App\Entity\TypeCorps;
use App\Form\TypeCorpsType;
use App\Repository\TypeCorpsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/corps')]
final class TypeCorpsController extends AbstractController
{
    #[Route(name: 'app_type_corps_index', methods: ['GET'])]
    public function index(TypeCorpsRepository $typeCorpsRepository): Response
    {
        return $this->render('type_corps/index.html.twig', [
            'type_corps' => $typeCorpsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_corps_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeCorp = new TypeCorps();
        $form = $this->createForm(TypeCorpsType::class, $typeCorp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeCorp);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_corps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_corps/new.html.twig', [
            'type_corp' => $typeCorp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_corps_show', methods: ['GET'])]
    public function show(TypeCorps $typeCorp): Response
    {
        return $this->render('type_corps/show.html.twig', [
            'type_corp' => $typeCorp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_corps_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeCorps $typeCorp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeCorpsType::class, $typeCorp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_corps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_corps/edit.html.twig', [
            'type_corp' => $typeCorp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_corps_delete', methods: ['POST'])]
    public function delete(Request $request, TypeCorps $typeCorp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeCorp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeCorp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_corps_index', [], Response::HTTP_SEE_OTHER);
    }
}
