<?php

namespace App\Controller;

use App\Entity\Connexion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        if ($session->get('utilisateur')) {
            return $this->redirectToRoute('app_dashboard');
        }

        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $confirm = $request->request->get('confirm_password');

            if ($password !== $confirm) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
            } else {
                $user = new Connexion();
                $user->setNom($nom);
                $user->setPrenom($prenom);
                $user->setEmail($email);
                $user->setMotsDePasse(password_hash($password, PASSWORD_BCRYPT));
                $user->setRoles(['ROLE_USER']); // Attribue le rôle par défaut

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
                return $this->redirectToRoute('app_connexion');
            }
        }

        return $this->render('connexion/inscription.html.twig');
    }

    #[Route('/connexion', name: 'app_connexion')]
    public function connexion(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $user = $em->getRepository(Connexion::class)->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email.');
                return $this->redirectToRoute('app_connexion');
            }

            if (!password_verify($password, $user->getMotsDePasse())) {
                $this->addFlash('error', 'Mot de passe incorrect.');
                return $this->redirectToRoute('app_connexion');
            }

            $session->set('utilisateur', [
                'id' => $user->getId(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ]);
            
            $this->addFlash('success', 'Bienvenue ' . $user->getPrenom() . ' !');
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('connexion/connexion.html.twig');
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(SessionInterface $session): Response
    {
        $utilisateur = $session->get('utilisateur');

        if (!$utilisateur) {
           $this->addFlash('error', 'Veuillez vous connecter pour accéder à votre espace.');
           return $this->redirectToRoute('app_connexion');
        }
        
        //dump($utilisateur->getEmail());
        //die;

        return $this->render('connexion/dashboard.html.twig', [
            'utilisateur' => $utilisateur
        ]);
    }

    #[Route('/deconnexion', name: 'app_deconnexion')]
    public function deconnexion(SessionInterface $session): Response
    {
        $session->clear();
        $this->addFlash('success', 'Vous avez été déconnecté.');
        return $this->redirectToRoute('app_connexion');
    }
}
