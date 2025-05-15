<?php

namespace App\Controller;

use App\Entity\Bouchon;
use App\Entity\BouchonVariante;
use App\Form\BouchonVarianteType;
use App\Repository\BouchonVarianteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/bouchonVariantes')]
final class BouchonVarianteController extends AbstractController
{
    // 🔹 Page publique : voir toutes les variantes
    #[Route('/', name: 'app_bouchon_variante_index', methods: ['GET'])]
    public function index(BouchonVarianteRepository $repository): Response
    {
        return $this->render('bouchon_variante/index.html.twig', [
            'bouchon_variantes' => $repository->findAll(),
        ]);
    }

    // 🔹 Page publique : voir les variantes d'un bouchon
    #[Route('/bouchon/{id}', name: 'app_bouchon_variante_show', methods: ['GET'])]
    public function showByBouchon(Bouchon $bouchon, BouchonVarianteRepository $repository): Response
    {
        $variantes = $repository->findBy(['bouchon' => $bouchon]);

        return $this->render('bouchon_variante/show.html.twig', [
            'bouchon' => $bouchon,
            'bouchon_variantes' => $variantes,
        ]);
    }

    // 🔹 Page admin : voir toutes les variantes
    #[Route('/admin', name: 'admin_bouchon_variante_index', methods: ['GET'])]
    public function adminIndex(BouchonVarianteRepository $repository): Response
    {
        return $this->render('bouchon_variante/index_admin.html.twig', [
            'bouchon_variantes' => $repository->findAll(),
        ]);
    }

    // 🔹 Page admin : voir les variantes d’un bouchon donné
    #[Route('/admin/bouchon/{id}', name: 'admin_bouchon_variante_show', methods: ['GET'])]
    public function adminShowByBouchon(Bouchon $bouchon, BouchonVarianteRepository $repository): Response
    {
        $variantes = $repository->findBy(['bouchon' => $bouchon]);

        return $this->render('bouchon_variante/admin_show.html.twig', [
            'bouchon' => $bouchon,
            'bouchon_variantes' => $variantes,
        ]);
    }

    // 🔹 Création
    #[Route('/new', name: 'app_bouchon_variante_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $bouchonVariante = new BouchonVariante();
        $form = $this->createForm(BouchonVarianteType::class, $bouchonVariante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($bouchonVariante);
            $em->flush();

            return $this->redirectToRoute('admin_bouchon_variante_index');
        }

        return $this->render('bouchon_variante/new.html.twig', [
            'bouchon_variante' => $bouchonVariante,
            'form' => $form,
        ]);
    }

    // 🔹 Édition
    #[Route('/{id}/edit', name: 'app_bouchon_variante_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BouchonVariante $bouchonVariante, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BouchonVarianteType::class, $bouchonVariante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_bouchon_variante_index');
        }

        return $this->render('bouchon_variante/edit.html.twig', [
            'bouchon_variante' => $bouchonVariante,
            'form' => $form,
        ]);
    }

    // 🔹 Suppression
    #[Route('/{id}', name: 'app_bouchon_variante_delete', methods: ['POST'])]
    public function delete(Request $request, BouchonVariante $bouchonVariante, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bouchonVariante->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($bouchonVariante);
            $em->flush();
        }

        return $this->redirectToRoute('admin_bouchon_variante_index');
    }

}
