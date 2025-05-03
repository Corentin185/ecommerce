<?php

// src/Controller/PanierController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\BouchonVarianteRepository;

final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function panier(
        Request $request,
        SessionInterface $session,
        BouchonVarianteRepository $bouchonVarianteRepository
    ): Response {

        $panier = $session->get('panier', []);

        $produits = [];
        $total = 0;
    
        foreach ($panier as $id => $quantite) {
            $bouchon = $bouchonVarianteRepository->find($id);
            if ($bouchon) {
                $produits[] = [
                    'produit' => $bouchon,
                    'quantite' => $quantite,
                    'soustotal' => $quantite * $bouchon->getPrix()
                ];                
                $total += $quantite * $bouchon->getPrix(); // 2€ prix fixe, à adapter si besoin
               // dump('total  :', $total);
                //die();
            }
        }
        //dump($produits);
        //die();
        return $this->render('panier/panier.html.twig', [
            'cart' => $produits,
            'total' => $total
        ]);
    }

    #[Route('/panier/ajouter/{id}', name: 'panier_ajouter', methods: ['POST'])]
    public function ajouter(int $id, Request $request, SessionInterface $session, BouchonVarianteRepository $bouchonVarianteRepository): RedirectResponse 
    {
        //dump('ID reçu :', $id);
        //dump('POST data :', $request->request->all());
        //dump('Panier avant modification :', $session->get('panier'));
   
        $produit = $bouchonVarianteRepository->find($id);
    
        //dump('Produits :', $produit);

        if (!$produit) {
            throw $this->createNotFoundException("Produit introuvable.");
        }
    
        // Récupérer le panier depuis la session (ou tableau vide)
        $panier = $session->get('panier', []);
       // dump('Panier session :', $panier);

        // Ajouter ou incrémenter la quantité
        $panier[$id] = ($panier[$id] ?? 0) + 1;
        //dump('Panier session 1:', $panier);

        // Sauvegarder dans la session
        $session->set('panier', $panier);

        //dump('Panier session 2 :', $panier);

        
        // Rediriger vers la page du panier
        return $this->redirectToRoute('panier');
    }
    #[Route('/panier/modifier', name: 'panier_modifier', methods: ['POST'])]
    public function modifier(Request $request, SessionInterface $session): RedirectResponse
    {
        $quantites = $request->request->all('quantites'); // ✅ ici
        $panier = $session->get('panier', []);
    
        foreach ($quantites as $id => $qte) {
            if ((int)$qte > 0) {
                $panier[$id] = (int)$qte;
            }
        }
    
        $session->set('panier', $panier);
        return $this->redirectToRoute('panier');
    }
    
#[Route('/panier/supprimer/{id}', name: 'panier_supprimer')]
public function supprimer(int $id, SessionInterface $session): RedirectResponse
{
    $panier = $session->get('panier', []);
    unset($panier[$id]);
    $session->set('panier', $panier);

    return $this->redirectToRoute('panier');
}
#[Route('/panier/vider', name: 'panier_vider')]
public function vider(SessionInterface $session): RedirectResponse
{
    $session->remove('panier');
    return $this->redirectToRoute('panier');
}

}
