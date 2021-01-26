<?php

namespace App\Controller;

use App\Form\InscriptionType;
use App\Form\ConnexionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('index_membre');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $formConnexion = $this->createForm(ConnexionType::class);
        $formInscription = $this->createForm(InscriptionType::class);

        return $this->render('security/login.html.twig', [
            'formConnexion' => $formConnexion->createView(),
            'formInscription' => $formInscription->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/login_success", name="login_success")
     */
    public function login_success(): response
    {

        $this->addFlash(
            'success',
            'Connexion réussi'
        );

        return $this->redirectToRoute('index_membre');
    }

    /**
     * @Route("/login_fail", name="login_fail")
     */
    public function login_fail(): response
    {

        $this->addFlash(
            'alert',
            'La connexion a échouée'
        );

        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
