<?php

namespace App\Controller;

use App\Repository\BouchonVarianteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheBouchonController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche', methods: ['GET'])]
    public function index(Request $request, BouchonVarianteRepository $repo): Response
    {
        $query = $request->query->get('q', '');
        $bouchons = $repo->searchByKeyword($query);

        return $this->render('recherche/recherche.html.twig', [
            'bouchons' => $bouchons,
            'query' => $query
        ]);
    }
}
