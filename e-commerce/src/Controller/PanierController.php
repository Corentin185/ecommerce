<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PanierController extends AbstractController
{
    public function panier(Request $request): Response
    {
        // Votre logique ici
        return $this->render('panier/panier.html.twig');
    }
}

