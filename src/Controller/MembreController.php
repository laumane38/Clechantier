<?php

namespace App\Controller;

use App\Entity\Adress;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AvatarType;
use App\Form\AdressType;
use App\Form\ProfilType;
use App\Form\PasswordModifyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Require ROLE_USER for *every* controller method in this class.
 *
 * @IsGranted("ROLE_USER")
 */
class MembreController extends AbstractController
{
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @Route("/membre", name="index_membre")
     */
    public function index(): Response
    {
        return $this->render('pages/membre.html.twig');
    }

    /**
     * @Route("/profilModify", name="profilModify")
     */
    public function profilModify(): Response
    {
        return $this->render('pages/profilModify.html.twig');
    }

    /**
     * @Route("/adress", name="adress")
     */
    public function adress(Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $adress = new Adress;

        $formAdress = $this->createForm(AdressType::class, $adress);
        $formAdress->handleRequest($request);

        if ($formAdress->isSubmitted() && $formAdress->isValid())
        {

            $sub = $request->request->get('adress');

            //si le code postal n'est pas renseigné on donne une valeur null pour que le code postal existe
            if($sub['zipCode']==="") $sub['zipCode']= null;

            //si l'adresse n'est pas défini par defaut on lui donne valeur 0
            //sinon on ne modife pas sa valeur mais on modifie la base de données pour que l'ancienne adresse par defaut ne le soit plus
            if(empty($sub['defaultAdress'])){
                $sub['defaultAdress'] = 0;
            }
            else{

                $repo = $em->getRepository(Adress::class);
                $adressToSetNotDefault = $repo->findBy([
                    'idProfil' => $user->getId(),
                    'enable' => '1',
                    'defaultAdress' => '1'
                ]);
                
                if(!empty($adressToSetNotDefault))
                {
                    $adressToSetNotDefault[0]->setDefaultAdress(0);

                    $em->persist($adressToSetNotDefault[0]);
                    $em->flush();
                }
            }

            
            $adress->setIdProfil($user->getId());
            $adress->setEnable(1);
            

            if($adress->getAdressTitle()!==""){

                $em->persist($adress);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Nouvelle adresse enregistrée avec succès.'
                );

                return $this->redirectToRoute('adress');
                
            }
            else{

                $this->addFlash(
                    'alert',
                    'Donnez un titre à cette adresse.'
                );
            }

        }
        

        $repo = $em->getRepository(Adress::class);
        $adress = $repo->findBy([
            'idProfil' => $user->getId(),
            'enable' => '1'
        ],[
            'defaultAdress'=>'DESC',
            'id' => 'DESC'
        ]);

        return $this->render('pages/adress.html.twig',[
            'formAdress' => $formAdress->createView(),
            'adress' => $adress
        ]);
    }

    /**
     * @Route("/profilEdit", name="profilEdit")
     */
    public function profilEdit(Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $formEditProfil = $this->createForm(ProfilType::class,$user);

        $formEditProfil->handleRequest($request);

        if ($formEditProfil->isSubmitted() && $formEditProfil->isValid())
        {


            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre profil a été mis à jour.'
            );

            return $this->redirectToRoute('profilEdit');

        }

        return $this->render('pages/profilEdit.html.twig',[
            'formEditProfil' => $formEditProfil->createView(),
            'editProfil' => $formEditProfil,
            'avatar' => $user->getAvatar()
        ]);

    }

    /**
     * @Route("/avatarEdit", name="avatarEdit")
     */
    public function avatarEdit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $formAvatar = $this->createForm(AvatarType::class);

        $formAvatar->handleRequest($request);

        if ($formAvatar->isSubmitted() && $formAvatar->isValid()){

            $sub = $request->request->get('avatar');

            $user->setAvatar($sub['avatar']);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre avatar a été mis a jour.'
            );

            return $this->redirectToRoute('profilEdit');

        }

        return $this->render('pages/avatarEdit.html.twig',[
            'formAvatar' => $formAvatar->createView(),
            'editProfil' => $formAvatar
        ]);
    }

    /**
     * @Route("/passwordModify", name="passwordModify")
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

        return $this->render('pages/passwordModify.html.twig',[
            'formPasswordModify' => $formPasswordModify->createView()
        ]);

    }

}