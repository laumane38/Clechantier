<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\ConnexionType;
use DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/register", name="register")
     */
    public function register(Request $request): response
    {
        $formInscription = $this->createForm(InscriptionType::class);
        if ($request->isMethod('POST')) {
            $formInscription->submit($request->request->get($formInscription->getName()));

            if ($formInscription->isSubmitted()) {

                $dateTimeImmutable = new DateTimeImmutable();

                //on récupère les information nécessaires à la création du compte
                $sub = $request->request->get('inscription');

                if (empty($sub['CGU'])) {
                    return $this->redirectToRoute('register_fail_cgu');
                }

                //on initialise les valeurs
                $roles[] = 'ROLE_USER';

                $entityManager = $this->getDoctrine()->getManager();
                $user = new User;
                $user->setPseudo($sub['pseudo']);
                $user->setPassword($this->userPasswordEncoder->encodePassword($user, "password"));
                $user->setEmail($sub['email']);
                $user->setRoles($roles);
                $user->setConnectedAt($dateTimeImmutable);
                $user->setRegisteredAt($dateTimeImmutable);

                // on verifie que le pseudo n'existe pas encore
                $emPseudo = $entityManager->getRepository(User::class)->findBy(array('pseudo' => $user->getPseudo()));
                // on verifie que l'email n'existe pas encore
                $emEmail = $entityManager->getRepository(User::class)->findBy(array('email' => $user->getEmail()));


                //si le pseudo et l'email n'existe pas encore dans la base de donnée alors on autorise les enregistrements
                if (empty($emEmail) && empty($emPseudo)) {
                    //on insert le nouvel utilisateur dans la base de données
                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $this->redirectToRoute('register_success');
                } elseif (!empty($emEmail)) {
                    return $this->redirectToRoute('register_fail_email');
                } elseif (!empty($emPseudo)) {
                    return $this->redirectToRoute('register_fail_pseudo');
                }
            }
        }


        return $this->render('security/register.html.twig', [
            'formInscription' => $formInscription->createView()
        ]);
    }

    /**
     * @Route("/register_fail_CGU", name="register_fail_cgu")
     */
    public function register_fail_cgu(): response
    {
        $this->addFlash(
            'alert',
            'L\'enregistrement a échouée. Vous devez accepter les conditions générales d\'utilisation'
        );

        return $this->redirectToRoute('register');
    }

    /**
     * @Route("/register_fail_pseudo", name="register_fail_pseudo")
     */
    public function register_fail_pseudo(): response
    {
        $this->addFlash(
            'alert',
            'L\'enregistrement a échouée. Le pseudo est déjà utilisé par un autre utilisateur'
        );

        return $this->redirectToRoute('register');
    }

    /**
     * @Route("/register_fail_email", name="register_fail_email")
     */
    public function register_fail_email(): response
    {
        $this->addFlash(
            'alert',
            'L\'enregistrement a échouée. L\'email est déjà utilisé par un autre utilisateur'
        );

        return $this->redirectToRoute('register');
    }

    /**
     * @Route("/register_success", name="register_success")
     */
    public function register_success(): response
    {
        $this->addFlash(
            'success',
            'L\'enregistrement du compte a été éffectué avec succès'
        );

        return $this->redirectToRoute('index_membre');
    }
}
