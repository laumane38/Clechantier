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

        $formAdress = $this->createForm(AdressType::class);

        if ($request->isMethod('POST')) {
            
            $formAdress->submit($request->request->get($formAdress->getName()));

            if($formAdress->isSubmitted())
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

                $adress = new Adress;
                $adress->setIdProfil($user->getId());
                $adress->setAdressTitle($sub['adressTitle']);
                $adress->setGender($sub['gender']);
                $adress->setFirstName($sub['firstName']);
                $adress->setLastName($sub['lastName']);
                $adress->setCompanie($sub['companie']);
                $adress->setAdress($sub['adress']);
                $adress->setAdress2($sub['adress2']);
                $adress->setAppartmentNumber($sub['appartmentNumber']);
                $adress->setFloor($sub['floor']);
                $adress->setZipCode($sub['zipCode']);
                $adress->setCity($sub['city']);
                $adress->setCountry($sub['country']);
                $adress->setDefaultAdress($sub['defaultAdress']);
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

        $formEditProfil = $this->createForm(ProfilType::class);


        if ($request->isMethod('POST')) {

            $formEditProfil->submit($request->request->get($formEditProfil->getName()));

            if($formEditProfil->isSubmitted()){

                $sub = $request->request->get('profil');

                $user->setGender($sub['gender']);
                $user->setFirstName($sub['firstName']);
                $user->setLastName($sub['lastName']);
                $user->setEmail($sub['email']);
                $user->setCompanie($sub['companie']);

                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Votre profil a été mis à jour.'
                );

                return $this->redirectToRoute('profilEdit');
                
            }

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

        if ($request->isMethod('POST')) {

            $formAvatar->submit($request->request->get($formAvatar->getName()));

            if($formAvatar->isSubmitted()){

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

        if ($request->isMethod('POST')) {

            $formPasswordModify->submit($request->request->get($formPasswordModify->getName()));

            if($formPasswordModify->isSubmitted()){

                $sub = $request->request->get('password_modify');

                $user->setPassword($this->userPasswordEncoder->encodePassword($user, $sub['password']));

                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Votre Mot de passe a été mis à jour.'
                );

            }

        }

        return $this->render('pages/passwordModify.html.twig',[
            'formPasswordModify' => $formPasswordModify->createView()
        ]);

    }


}
