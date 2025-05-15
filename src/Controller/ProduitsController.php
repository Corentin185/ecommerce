<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'app_produits')]
    public function index(): Response
    {
        $produits = [
            'bordure' => [
                'nom' => 'Flotteurs bordure',
                'type' => 'bordure',
                'prix' => 2.00,
            ],
            'plaine-eau' => [
                'nom' => 'Flotteurs plaine eau',
                'type' => 'plaine-eau',
                'prix' => 2.00,
            ],
            'personnalisation' => [
                'nom' => 'Flotteurs personnalisables',
                'type' => 'personnalisation',
                'prix' => 2.50,
            ],
            'pate' => [
                'nom' => 'Flotteurs pâte',
                'type' => 'pate',
                'prix' => 3.00,
            ]
        ];

        return $this->render('produits/produits.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/produit/{type}', name: 'app_produit')]
    public function show(string $type): Response
    {
        $produits = [
            'bordure' => [
                'nom' => 'Flotteurs bordure',
                'prix' => 2.00,
                'grammage' => [0.4, 0.5, 0.6, 0.75],
                'couleurs' => ['bleu', 'noir', 'gris', 'vert', 'jaune'],
                'antennes' => ['rouge', 'noir', 'orange', 'vert', 'jaune'],
                'antenne_longueur' => ['3cm'],
                'quille' => ['12cm'],
                'formes' => ['diamant', 'boule', 'long']
            ],
            'plaine-eau' => [
                'nom' => 'Flotteurs plaine eau',
                'prix' => 2.00,
                'grammage' => [0.4, 0.5, 0.6, 0.75, 0.8, 1],
                'couleurs' => ['bleu', 'noir', 'gris', 'vert', 'jaune'],
                'antennes' => ['rouge', 'noir', 'orange', 'vert', 'jaune'],
                'antenne_longueur' => ['4cm'],
                'quille' => ['15cm', '20cm'],
                'formes' => ['diamant', 'boule', 'long']
            ],
            'personnalisation' => [
                'nom' => 'Flotteurs personnalisables',
                'prix' => 2.50,
                'grammage' => [0.4, 0.5, 0.6, 0.75, 0.8, 1],
                'couleurs' => ['sur demande'],
                'antennes' => ['rouge', 'noir', 'orange', 'vert', 'jaune'],
                'antenne_longueur' => ['3cm', '4cm'],
                'quille' => ['15cm', '12cm', '20cm'],
                'formes' => ['diamant', 'boule', 'long']
            ],
            'pate' => [
                'nom' => 'Flotteurs pâte',
                'prix' => 3.00,
                'grammage' => [0.4, 0.5, 0.6, 0.75, 0.8, 1],
                'couleurs' => ['bleu', 'noir', 'gris', 'vert', 'jaune'],
                'antennes' => ['tricolores'],
                'antenne_longueur' => ['6cm'],
                'quille' => ['20cm'],
                'formes' => ['diamant', 'boule', 'long']
            ]
        ];

        if (!isset($produits[$type])) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        return $this->render('produits/show.html.twig', [
            'produit' => $produits[$type],
            'type' => $type
        ]);
    }
}
