<?php

// src/Controller/AdminDashboardController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminDashboardController extends AbstractController
{
    #[Route('/private-admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminPage(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
