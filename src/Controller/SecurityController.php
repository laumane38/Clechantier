<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Form\ConnexionType;
use App\Form\PasswordForgetType;
use App\Form\PasswordModifyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

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

        return $this->render('security/login.html.twig', [
            'formConnexion' => $formConnexion->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/login_success", name="login_success")
     * @IsGranted("ROLE_USER")
     */
    public function login_success(): response
    {

        $dateTimeImmutable = new DateTimeImmutable();
        $user = $this->getUser();
        $user->setConnectedAt($dateTimeImmutable);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $pseudo = $this->getUser()->getPseudo();
        $this->addFlash(
            'success',
            'Bonjour ' . $pseudo . ' votre authentification a réussi. Vous êtes désormais connecté'
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

    /**
     * @Route("/security/passwordForget", name="passwordForget")
     */
    public function passwordForget(){

        $formPasswordForget = $this->createForm(PasswordForgetType::class);


        return $this->render('security/passwordForget.html.twig',[
            'formPasswordForget' => $formPasswordForget->createView()
        ]);
    }

    /**
     * @Route("/security/passwordModify", name="passwordModify")
     * @IsGranted("ROLE_USER")
     */
    public function passwordModify(Request $request, EntityManagerInterface $em){

        $user = $this->getUser();
        $formPasswordModify = $this->createForm(PasswordModifyType::class);

        $formPasswordModify->handleRequest($request);

        if ($formPasswordModify->isSubmitted() && $formPasswordModify->isValid()){

            $sub = $request->request->get('password_modify');

            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $sub['password']));

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre Mot de passe a été mis à jour.'
            );

            return $this->redirectToRoute('passwordModify');

        }

        return $this->render('security/passwordModify.html.twig',[
            'formPasswordModify' => $formPasswordModify->createView()
        ]);

    }
}
