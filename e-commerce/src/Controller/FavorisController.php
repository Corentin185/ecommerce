<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\BouchonVarianteRepository;

class FavorisController extends AbstractController
{
    #[Route('/favoris', name: 'favoris')]
    public function index(
        SessionInterface $session,
        BouchonVarianteRepository $bouchonVarianteRepository
    ): Response {
        $favorisIds = $session->get('favoris', []);

        $produits = [];
        foreach ($favorisIds as $id) {
            $produit = $bouchonVarianteRepository->find($id);
            if ($produit) {
                $produits[] = $produit;
            }
        }

        return $this->render('favoris/favoris.html.twig', [
            'favoris' => $produits,
        ]);
    }

    #[Route('/favoris/ajouter/{id}', name: 'favoris_ajouter')]
public function ajouter(int $id, SessionInterface $session): Response
{
   
    $favoris = $session->get('favoris', []);
    if (!in_array($id, $favoris)) {
        $favoris[] = $id;
        $session->set('favoris', $favoris);
    }
    return $this->redirectToRoute('favoris');
}


    #[Route('/favoris/supprimer/{id}', name: 'favoris_supprimer')]
    public function supprimer(int $id, SessionInterface $session): Response
    {
        $favoris = $session->get('favoris', []);
        $session->set('favoris', array_filter($favoris, fn($fid) => $fid != $id));

        return $this->redirectToRoute('favoris');
    }
}
