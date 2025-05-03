<?php
 namespace App\Controller;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;


final class BaseController extends AbstractController
 {
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
           
        ]);
    }
    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('contact/contact.html.twig', [

        ]);
    }
    #[Route('/connexion', name: 'app_connexion')]
    public function connexion(): Response
    {
        return $this->render('connexion/connexion.html.twig', [

        ]);
    }
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(): Response
    {
        return $this->render('inscription/inscription.html.twig', [
           
        ]);
    }
  /*  #[Route('/panier', name: 'app_panier')]
    public function panier(): Response
    {
    // Exemple avec un panier vide
    $cart = [];

    // Ou récupérer depuis la session ou une base de données
    // $cart = $session->get('cart', []);

    return $this->render('panier/panier.html.twig', [
        'cart' => $cart,
    ]);
    }*/

    #[Route('/produits', name: 'app_produits')]
    public function produits(): Response
    {
        return $this->render('produits/produits.html.twig', [
        ]);
    }





 }